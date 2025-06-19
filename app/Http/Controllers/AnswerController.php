<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Events\AnswerSubmitted;
use App\Models\Participation;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Answer;

class AnswerController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'meeting_id' => 'required|exists:meetings,id',
        'choice'     => 'required|integer|between:0,3', // 0‑3
    ]);

    $user     = Auth::user();
    $meeting  = Meeting::with('quiz.questions.options')->findOrFail($request->meeting_id);

    /** 1. participación */
    $participation = Participation::firstOrCreate([
        'user_id'    => $user->id,
        'meeting_id' => $meeting->id,
    ]);

    /** 2. pregunta activa */
    $question = $meeting->currentQuestion;

    if (!$question) {
        return back()->with('error', 'No hay pregunta activa.');
    }

    /** 3. opción elegida (índice 0‑3) */
    $option = $question->options()->orderBy('id')->skip($request->choice)->first();

    if (!$option) {
        return back()->with('error', 'Opción inválida.');
    }

    /** 4. guardar / actualizar respuesta */
    Answer::updateOrCreate(
        [
            'participation_id' => $participation->id,
            'question_id'      => $question->id,
        ],
        ['option_id' => $option->id]
    );

    return back()->with('success', 'Respuesta registrada.');
}

}
