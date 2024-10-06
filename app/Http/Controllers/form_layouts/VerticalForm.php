<?php

namespace App\Http\Controllers\form_layouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerticalForm extends Controller
{
  public function index()
  {
    $user = Auth::user();
    return view('content.form-layout.form-layouts-vertical',compact('user'));
  }
}
