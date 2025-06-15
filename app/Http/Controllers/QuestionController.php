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

        preg_match_all('/^(.*?)\{(.*?)\}/ms', $content, $matches, PREG_SET_ORDER);
    
        foreach ($matches as $match) {
            preg_match_all('/([=~])([^=~]+)/', $match[2], $optionMatches, PREG_SET_ORDER);
            $questionText = trim($match[1]);
            $options = [];
            $correctIndex = null;
    
            foreach ($optionMatches as $i => $optMatch) {
                $sign = $optMatch[1]; // = o ~
                $text = trim($optMatch[2]);

                $options[] = $text;

                if ($sign === '=') {
                    $correctIndex = $i;
                }
            }
    
            if ($correctIndex === null || count($options) < 2) {
                continue;
            }
    
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'text' => $questionText,
            ]);
    
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
        $quiz->load('questions.options');
        return view('teacher.questions.show', compact('quiz'));
    }

    public function import(Quiz $quiz)
    {
        return view('teacher.questions.import', compact('quiz'));
    }
}
