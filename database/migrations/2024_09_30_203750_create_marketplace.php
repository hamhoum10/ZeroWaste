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
        // Products Table
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Product name
            $table->text('description')->nullable(); // Optional description
            $table->decimal('price', 10, 2); // Price (10 digits in total, 2 decimal places)
            $table->integer('quantity'); // Quantity in stock
            $table->string('image_url')->nullable(); // Product image URL
            $table->timestamps(); // Created at and updated at timestamps
        });

        // Carts Table
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Linked to users table (nullable for guest users)
            $table->decimal('total_price', 10, 2)->default(0); // Total price of the order
            $table->timestamps(); // Created at and updated at timestamps
        });

        // Cart Items Table
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Linked to carts table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Linked to products table
            $table->integer('quantity'); // Quantity of product in cart
            $table->timestamps(); // Created at and updated at timestamps
        });

        // Orders Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Linked to users table
            $table->decimal('total_price', 10, 2); // Total price of the order
            $table->string('status')->default('pending'); // Order status (e.g., pending, completed, etc.)
            $table->timestamps(); // Created at and updated at timestamps
        });

        // Order Items Table
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Linked to orders table
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Linked to products table
            $table->integer('quantity'); // Quantity of product in the order
            $table->decimal('price', 10, 2); // Price of the product at the time of the order
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
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('products');
    }
};
