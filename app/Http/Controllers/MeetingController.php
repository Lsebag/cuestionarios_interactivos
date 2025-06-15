<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Participation;
use App\Models\Meeting;
use App\Models\Answer;
use App\Models\Quiz;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::where('user_id', Auth::id())->with('quiz')->latest()->get();
        return view('teacher.meetings.index', compact('meetings'));
    }    

    public function create()
    {
        $quizzes = Quiz::where('user_id', Auth::id())->get();
        return view('teacher.meetings.create', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'meeting_name' => 'required|string|max:255',
            'quiz_id' => 'required|exists:quizzes,id',
        ]);
    
        $meeting = Meeting::create([
            'meeting_name' => $request->meeting_name,
            'quiz_id' => $request->quiz_id,
            'user_id' => Auth::id(),
            'status' => 'waiting',
            'access_code' => Str::random(8),
        ]);
    
        return redirect()->route('teacher.meetings.index')
            ->with('success', 'Sesión creada. Código: ' . $meeting->access_code);
    }

    public function show($id)
    {
        $meeting = Meeting::with([
            'quiz.questions.options',
        ])->where('user_id', Auth::id())->findOrFail($id);
        
        return view('teacher.meetings.show', compact('meeting'));
    }
    
    public function handleJoin(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);
    
        $meeting = Meeting::where('access_code', $request->access_code)->first();
    
        if (!$meeting) {
            return redirect()->route('student.join')->with('error', 'No existe una sesión válida con ese código de acceso.');
        }

        // Evita duplicar participación
        Participation::firstOrCreate([
            'user_id' => Auth::id(),
            'meeting_id' => $meeting->id,
        ], [
            'status' => 'joined',
        ]);

        if ($meeting->status === 'waiting') {
            return redirect()->route('student.join')->with('error', 'Espere que el profesor inicie la sesión.');
        }

        if ($meeting->status === 'finished') {
            return redirect()->route('student.results', ['meeting' => $meeting->id]);
        }

        // Redirige al juego solo si la sesión está iniciada
        return redirect()->route('student.meetings.play', ['access_code' => $meeting->access_code]);
    }

    public function start(Meeting $meeting)
    {
        $firstQuestion = $meeting->quiz->questions()->orderBy('id')->first();

        if ($firstQuestion) {
            $meeting->update([
                'status' => 'started',
                'current_question_id' => $firstQuestion->id,
            ]);
        } else {
            return back()->with('error', 'Este cuestionario no tiene preguntas.');
        }

        return back()->with('success', 'Sesión iniciada con la primera pregunta.');
    }

    public function joinView()
    {
        return view('student.meetings.join');
    }

    public function play($access_code)
    {
        $meeting = Meeting::with('quiz.questions.options')->where('access_code', $access_code)->firstOrFail();

        $participation = Participation::where('user_id', Auth::id())
            ->where('meeting_id', $meeting->id)
            ->firstOrFail();

        if ($meeting->status !== 'started') {
            return redirect()->route('student.join')->with('error', 'La sesión aún no ha comenzado.');
        }

        return view('student.meetings.play', compact('meeting'));
    }

    public function showStudentResults(Meeting $meeting)
    {
        if ($meeting->status !== 'finished') {
            return back()->with('error', 'La sesión aún no ha finalizado.');
        }

        $participation = $meeting->participations()
            ->with(['answers'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('student.meetings.results', [
            'meeting' => $meeting,
            'participation' => $participation,
        ]);
    }
}
