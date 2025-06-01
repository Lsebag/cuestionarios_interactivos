<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function storeImport(Request $request, Quiz $quiz)
    {
        $request->validate([
            'gift_file' => 'required|file|mimes:txt|max:2048',
        ]);
    
        $file = $request->file('gift_file');
        $content = file_get_contents($file->getRealPath());
    
        // GIFT básico: solo soportaremos 4 preguntas tipo opción múltiple con una correcta entre llaves: {=correcta ~incorrecta ~incorrecta ~incorrecta}
        $questionsParsed = [];
    
        preg_match_all('/^(.*?)\{(.*?)\}/ms', $content, $matches, PREG_SET_ORDER);
    
        foreach ($matches as $match) {
            $questionText = trim($match[1]);
            $answersRaw = explode('~', $match[2]);
            $options = [];
            $correctIndex = null;
    
            foreach ($answersRaw as $index => $option) {
                $option = trim($option);
                if (str_starts_with($option, '=')) {
                    $options[] = ltrim($option, '=');
                    $correctIndex = $index;
                } else {
                    $options[] = $option;
                }
            }
    
            if ($correctIndex === null || count($options) < 2) {
                continue; // Skip malformed question
            }
    
            // Crear pregunta
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'text' => $questionText,
            ]);
    
            // Crear opciones (debes tener una relación hasMany en el modelo Question)
            foreach ($options as $i => $optionText) {
                $question->options()->create([
                    'text' => $optionText,
                    'is_correct' => $i === $correctIndex,
                ]);
            }
        }
    
        return redirect()->route('teacher.quizzes.index')->with('success', 'Preguntas importadas correctamente.');
    }

    public function showByQuiz(Quiz $quiz)
    {
        $quiz->load('questions.options'); // Eager load para evitar consultas múltiples
        return view('teacher.questions.show', compact('quiz'));
    }

    public function import(Quiz $quiz)
    {
        return view('teacher.questions.import', compact('quiz'));
    }
}
