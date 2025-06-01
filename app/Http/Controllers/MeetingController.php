<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Participation;
use App\Models\Meeting;
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
        $meeting = Meeting::with('quiz')->where('user_id', Auth::id())->findOrFail($id);
        return view('teacher.meetings.show', compact('meeting'));
    }
    
    public function handleJoin(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string|exists:meetings,access_code',
        ]);
    
        $meeting = Meeting::where('access_code', $request->access_code)->firstOrFail();
    
        // Evita duplicar participación
        Participation::firstOrCreate([
            'user_id' => Auth::id(),
            'meeting_id' => $meeting->id,
        ], [
            'status' => 'joined',
        ]);
    
        return redirect()->route('meeting.join', $meeting->access_code);
    }
    
}
