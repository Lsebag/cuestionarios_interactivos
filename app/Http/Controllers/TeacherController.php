<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MeetingController;
use Illuminate\Http\Request;
use App\Models\Meeting;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.dashboard');
    }
}
