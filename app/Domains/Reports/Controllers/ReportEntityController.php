<?php

namespace App\Domains\Reports\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ReportEntityController extends Controller
{
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:view reports')->only(['index']);
    }
    public function index(): View
    {
        $titlePage = 'التقارير';
        return view('reports::admin.index', compact('titlePage'));
    }
}


