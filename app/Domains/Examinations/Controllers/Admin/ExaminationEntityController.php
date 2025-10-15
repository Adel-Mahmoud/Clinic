<?php

namespace App\Domains\Examinations\Controllers\Admin;

use App\Http\Controllers\Controller;

class ExaminationEntityController extends Controller
{
    public function index()
    {
        return view('examinations::admin.index');
    }
}