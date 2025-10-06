<?php

namespace App\Domains\Doctors\Controllers\Web;

use App\Http\Controllers\Controller;

class DoctorEntityController extends Controller
{
    public function index()
    {
        return view('doctors::web.index');
    }
}