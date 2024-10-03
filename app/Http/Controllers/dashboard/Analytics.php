<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  public function index()
  {
    $user = Auth::user();
    return view('content.dashboard.dashboards-analytics', compact('user'));
  }
}
