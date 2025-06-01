<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Meeting;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.dashboard');
    }

    public function meetings()
    {
        $attendedMeetings = Meeting::whereHas('students', function ($query) {
            $query->where('user_id', Auth::id())->get();
        })->with('quiz')->get();

        return view('student.meetings.index', compact('attendedMeetings'));
    }

    public function showMeetings()
    {
        // $meetings = auth()->user()->meetings()->with('quiz')->get();
        $meetings = Meeting::whereHas('students', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('quiz')->get();

        return view('student.meetings.index', compact('meetings'));
    }
    
}
