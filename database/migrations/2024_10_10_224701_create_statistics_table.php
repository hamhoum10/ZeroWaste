<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('statistics', function (Blueprint $table) {
      $table->id();
      $table->string('type'); // daily, weekly, monthly
      $table->string('metric'); // e.g. users_registered, total_active_users
      $table->decimal('value', 15, 2); // decimal to support revenue and other metrics
      $table->date('date'); // The date the stat is for
      $table->timestamps(); // created_at and updated_at
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('statistics');
  }
};
