<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->timestamps();
        });

        
        Schema::create('user_auth', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('email');
            $table->string('password');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user_info')->onDelete('cascade');
        });

        
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->decimal('discount_percentage', 5, 2);
            $table->date('expiry_date');
            $table->timestamps();
        });

        
        Schema::create('shipping_address', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('street_adr');
            $table->string('city');
            $table->string('region');
            $table->string('postal_code');
            $table->timestamps();
        });

        
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('created_at');
            $table->unsignedBigInteger('promocode_id')->unique()->nullable();
            $table->unsignedBigInteger('ship_adr_id');
            $table->enum('shipping_method', ['standard', 'express']);
            $table->enum('payment_method', ['card', 'cash', 'paypal']);

            $table->foreign('user_id')->references('id')->on('user_info')->onDelete('cascade');
            $table->foreign('promocode_id')->references('id')->on('promo_codes')->nullOnDelete();
            $table->foreign('ship_adr_id')->references('id')->on('shipping_address')->onDelete('cascade');
        });

        
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        
        Schema::create('order_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });

        
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        
        Schema::create('categories_product', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');

            $table->primary(['category_id', 'product_id']);

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });

        
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('ingredient_id');

            $table->primary(['ingredient_id', 'product_id']);

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });

        
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->text('image_data');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });

        
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('user_info')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts'); 
        Schema::dropIfExists('images');
        Schema::dropIfExists('product_ingredients');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('categories_product');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('order_item');
        Schema::dropIfExists('product');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('shipping_address');
        Schema::dropIfExists('promo_codes');
        Schema::dropIfExists('user_auth');
        Schema::dropIfExists('user_info');
    }
};