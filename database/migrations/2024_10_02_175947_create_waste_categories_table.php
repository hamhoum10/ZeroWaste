<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('waste_categories', function (Blueprint $table) {
      $table->id(); // This creates an unsignedBigInteger primary key named 'id'
      $table->string('name'); // Name of the waste category
      $table->text('description')->nullable(); // Description of the waste category
      $table->timestamps(); // Created at and updated at timestamps
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('waste_categories');
  }
};
