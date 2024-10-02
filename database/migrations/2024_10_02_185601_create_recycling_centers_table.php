<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecyclingCentersTable extends Migration
{
  public function up()
  {
    Schema::create('recycling_centers', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('address');
      $table->string('phone')->nullable();
      $table->unsignedBigInteger('waste_category_id'); // Foreign key
      $table->foreign('waste_category_id')->references('id')->on('waste_categories')->onDelete('cascade');
      $table->decimal('latitude', 10, 7)->nullable(); // Adding latitude
      $table->decimal('longitude', 10, 7)->nullable(); // Adding longitude
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('recycling_centers');
  }
}
