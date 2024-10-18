<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;

class StatisticService
{
  // Method to update all statistics at once
  public function updateAllStatistics($type = 'daily')
  {
    // Calculate all the required statistics, set to 0 if empty
    $totalUsers = User::whereDate('created_at', Carbon::today())->count() ?? 0;
    $totalOrders = Order::whereDate('created_at', Carbon::today())->count() ?? 0;
    $totalRevenue = Order::whereDate('created_at', Carbon::today())->sum('total_price') ?? 0;
    $totalProducts = Product::whereDate('created_at', Carbon::today())->count() ?? 0;

    // Save each statistic using the saveStatistic method
    $this->saveStatistic($type, 'total_users', $totalUsers);
    $this->saveStatistic($type, 'total_orders', $totalOrders);
    $this->saveStatistic($type, 'total_revenue', $totalRevenue);
    $this->saveStatistic($type, 'total_products', $totalProducts);
  }

  // Helper method to save or update a specific statistic
  protected function saveStatistic($type, $metric, $value)
  {
    $today = Carbon::today();

    Statistic::updateOrCreate(
      ['type' => $type, 'metric' => $metric, 'date' => $today],
      ['value' => $value]
    );
  }
}
