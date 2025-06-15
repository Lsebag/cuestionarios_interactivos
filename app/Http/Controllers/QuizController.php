<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('user_id', Auth::id())->get();
        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('teacher.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('teacher.quizzes.index')->with('success', 'Cuestionario creado correctamente.');
    }

    public function edit(Quiz $quiz)
    {
        return view('teacher.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('teacher.quizzes.index')->with('success', 'Cuestionario actualizado.');
    }
}
