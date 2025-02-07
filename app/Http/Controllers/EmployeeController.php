<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        return view('employee.dashboard');
    }

    public function profile()
    {
        $employee = Auth::user();
        return view('employee.profile', compact('employee'));
    }
}
