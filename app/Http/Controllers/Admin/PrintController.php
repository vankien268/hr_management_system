<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PrintController extends Controller
{
    public function index()
      {
            $students = User::all();
            return view('students')->with('students', $students);;
      }
}
