<?php

namespace App\Domains\Patients\Controllers\Web;

use App\Http\Controllers\Controller;

class PatientEntityController extends Controller
{
    public function index()
    {
        return view('patients::web.index');
    }
}