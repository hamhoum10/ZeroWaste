<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
  public function logAction($action, $description = null)
  {
    Log::create([
      'action' => $action,
      'performed_by' => Auth::id(),
      'description' => $description,
    ]);
  }
}
