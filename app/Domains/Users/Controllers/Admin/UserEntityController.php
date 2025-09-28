<?php

namespace App\Domains\Users\Controllers\Admin;

use App\Http\Controllers\Controller;

class UserEntityController extends Controller
{
    public function index()
    {
        return view('users::admin.index');
    }
}