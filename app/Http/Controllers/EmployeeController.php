<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        return view('employee.dashboard');
    }
}
