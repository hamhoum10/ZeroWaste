<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('logs', function (Blueprint $table) {
      $table->id();
      $table->string('action'); // e.g., "login", "logout", "make_order"
      $table->unsignedBigInteger('performed_by'); // foreign key for the user
      $table->text('description'); // optional: additional details about the action
      $table->timestamps();

      // Set foreign key constraint
      $table->foreign('performed_by')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('logs');
  }
};
