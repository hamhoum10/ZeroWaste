<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginBasic extends Controller
{
  public function __construct(LogService $logService){
    $this->logService = $logService;
  }
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
      // Log the login action
      $this->logService->logAction('login', 'User logged in');
      return redirect()->route('dashboard-analytics'); // Redirect to intended page
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ]);
  }
}
