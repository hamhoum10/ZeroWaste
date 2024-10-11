<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LogService;
use App\Services\StatisticService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterBasic extends Controller
{

  public function __construct(StatisticService $statisticService, LogService $logService)
  {
    $this->statisticService = $statisticService;
    $this->logService = $logService;
  }

  public function index()
  {
    return view('content.authentications.auth-register-basic');
  }

  public function register(Request $request)
  {
    // Validate the request
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the user with the 'user' role by default
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => 'user', // Default role as 'user'
    ]);

    // Log the user in automatically after registration
    auth()->login($user);

    // Update the total users statistic
    $this->statisticService->updateAllStatistics();

    // Log the registration action
    $this->logService->logAction('registration', 'User registered successfully');

    // Redirect to a default page
    return redirect()->route('dashboard-analytics');
  }
}
