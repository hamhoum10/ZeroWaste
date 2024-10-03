<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
    // Validate the login credentials
    $credentials = $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
    ]);

    // Attempt to log the user in
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->route('dashboard-analytics'); // Redirect to intended page
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ]);
  }
}
