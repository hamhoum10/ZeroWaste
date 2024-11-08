<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('recycling_tips', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description');
      $table->string('category'); // e.g., Plastic, Paper, etc.
      $table->foreignId('posted_by')->constrained('users'); // Assuming you have a users table
      $table->timestamp('date_posted')->useCurrent();
      $table->integer('likes_count')->default(0);
      $table->boolean('approved')->default(false);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('recycling_tips');
  }
};
