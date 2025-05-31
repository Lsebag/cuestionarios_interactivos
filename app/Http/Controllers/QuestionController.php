<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuestionController extends Controller
{
    public function import(Quiz $quiz)
    {
        return view('teacher.questions.import', compact('quiz'));
    }
}
