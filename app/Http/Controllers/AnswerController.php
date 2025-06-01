<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Events\AnswerSubmitted;
use App\Models\Participation;
use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'required|exists:options,id',
            'meeting_id' => 'required|exists:meetings,id',
        ]);

        // Encontrar participación del estudiante en esa reunión
        $participation = Participation::where('user_id', Auth::id())
            ->where('meeting_id', $request->meeting_id)
            ->firstOrFail();

        // Guardar o actualizar respuesta
        $answer = Answer::updateOrCreate(
            [
                'participation_id' => $participation->id,
                'question_id' => $request->question_id,
            ],
            [
                'option_id' => $request->option_id,
            ]
        );

        // Emitir evento
        broadcast(new AnswerSubmitted($answer))->toOthers();

        return response()->json(['status' => 'ok']);
    }
}
