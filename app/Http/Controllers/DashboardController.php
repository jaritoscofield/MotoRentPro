<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Exibir o dashboard
     */
    public function index()
    {
        return view('modules.dashboard.index');
    }
}
