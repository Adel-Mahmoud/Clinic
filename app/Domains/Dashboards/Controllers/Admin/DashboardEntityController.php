<?php

namespace App\Domains\Dashboards\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardEntityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dashboard')->only(['index']);
    }
    public function index()
    {
        return view('dashboards::admin.index');
    }
}