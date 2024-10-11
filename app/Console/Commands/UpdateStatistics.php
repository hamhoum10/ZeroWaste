<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStatistics extends Command
{
  protected $signature = 'statistics:update';
  protected $description = 'Update daily, weekly, and monthly statistics';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Daily statistics
    $this->updateDailyStatistics();
    // Similarly, you can add methods for weekly and monthly stats
  }

  protected function updateDailyStatistics()
  {
    $totalUsers = User::count();
    $totalOrders = Order::count();
    $totalRevenue = Order::sum('total_price');
    $totalProducts = Product::count();

    $this->saveStatistic('daily', 'total_users', $totalUsers);
    $this->saveStatistic('daily', 'total_orders', $totalOrders);
    $this->saveStatistic('daily', 'total_revenue', $totalRevenue);
    $this->saveStatistic('daily', 'total_products', $totalProducts);
  }

  protected function saveStatistic($type, $metric, $value)
  {
    $today = Carbon::today();

    Statistic::updateOrCreate(
      ['type' => $type, 'metric' => $metric, 'date' => $today],
      ['value' => $value]
    );
  }
}
