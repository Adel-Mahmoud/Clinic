<?php

namespace App\Domains\Examinations\Controllers\Web;

use App\Http\Controllers\Controller;

class ExaminationEntityController extends Controller
{
    public function index()
    {
        return view('examinations::web.index');
    }
}