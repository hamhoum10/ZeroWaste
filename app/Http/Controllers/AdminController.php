<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function viewUserLogs(Request $request)
  {
    // Fetch search filters
    $userSearch = $request->input('user');
    $actionSearch = $request->input('action');
    $dateSearch = $request->input('date');

    // Fetch logs with filtering
    $logs = Log::with('user')
      ->when($userSearch, function ($query, $userSearch) {
        $query->whereHas('user', function ($query) use ($userSearch) {
          $query->where('name', 'like', '%' . $userSearch . '%');
        });
      })
      ->when($actionSearch, function ($query, $actionSearch) {
        $query->where('action', 'like', '%' . $actionSearch . '%');
      })
      ->when($dateSearch, function ($query, $dateSearch) {
        $query->whereDate('created_at', $dateSearch);
      })
      ->orderBy('created_at', 'desc')
      ->paginate(5);

    return view('admin.user-logs', compact('logs'));
  }
}
