<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MeetingController;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Question;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.dashboard');
    }

    public function showQuestion(Meeting $meeting, Question $question)
    {
        if (!$meeting->quiz->questions->contains($question)) {
            return back()->with('error', 'Pregunta inválida para este cuestionario.');
        }

        $meeting->update([
            'current_question_id' => $question->id,
        ]);

        return back()->with('success', 'Se ha mostrado la siguiente pregunta.');
    }

    public function finishMeeting(Meeting $meeting)
    {
        $meeting->update(['status' => 'finished']);

        return redirect()->route('teacher.results', $meeting);
    }

    public function showResults(Meeting $meeting)
    {
    $questions = $meeting->quiz
        ->questions()
        ->with(['options' => function ($q) use ($meeting) {
            $q->withCount(['answers as responses_count' => function ($a) use ($meeting) {
                $a->whereHas('participation',
                    fn ($p) => $p->where('meeting_id', $meeting->id));
            }]);
        }])
        ->get();

        return view('teacher.meetings.results', compact('meeting', 'questions'));
    }
}
