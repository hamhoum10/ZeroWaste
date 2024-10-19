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
    Schema::create('challenges', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->string('category');
      $table->date('start_date');
      $table->date('end_date');
      $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
      $table->integer('participants_count')->default(0);
      $table->string('status')->default('Ongoing'); // Ongoing or Completed
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('challenges');
  }
};
