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
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'required|exists:options,id',
            'meeting_id' => 'required|exists:meetings,id',
        ]);

        $user = Auth::user();
        $meeting = Meeting::with('quiz.questions')->findOrFail($request->meeting_id);

        /** ---------- 1. asegura participación ---------- */
        $participation = Participation::firstOrCreate([
            'user_id'    => $user->id,
            'meeting_id' => $meeting->id,
        ]);

        // Rechazar si la pregunta enviada no es la actual
        if ($meeting->current_question_id != $request->question_id) {
            return back()->with('error', 'La pregunta ya no está activa. Espera que el profesor avance.');
        }

        /** ---------- 2. guarda la respuesta si no existe ---------- */
        Answer::firstOrCreate(
            [
                    'participation_id' => $participation->id,
                    'question_id'      => $request->question_id,
            ],
            ['option_id' => $request->option_id]
        );

        /** ---------- 3. calcula la siguiente pregunta ---------- */
        $questions    = $meeting->quiz->questions()->orderBy('id')->get();
        $currentIndex = $questions->search(fn ($q) => $q->id == $request->question_id);
        $nextQuestion = $questions->get($currentIndex + 1);   // null si era la última

        if ($nextQuestion) {
            // mueve el puntero
            $meeting->update(['current_question_id' => $nextQuestion->id]);
        } else {
            // no hay más → se termina la sesión
            $meeting->update(['status' => 'finished', 'current_question_id' => null]);
            return redirect()
                ->route('student.results', $meeting->id)
                ->with('success', '¡Cuestionario finalizado! Aquí tienes tus resultados.');
        }

        return back()->with('success', 'Respuesta guardada correctamente.');
    }
}
