<?php

namespace App\Domains\Reports\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ReportEntityController extends Controller
{
    
    public function index(): View
    {
        $titlePage = 'التقارير';
        return view('reports::admin.index', compact('titlePage'));
    }
}


