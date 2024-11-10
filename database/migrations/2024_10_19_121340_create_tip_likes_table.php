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
    Schema::create('tip_likes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The user who liked the tip
      $table->foreignId('recycling_tip_id')->constrained()->onDelete('cascade'); // The tip that was liked
      $table->timestamps();

      // Ensure a user can only like a tip once
      $table->unique(['user_id', 'recycling_tip_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tip_likes');
  }
};
