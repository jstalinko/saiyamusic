<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_category_id');
            $table->string('name');
            $table->text('description');
            $table->string('model');
            $table->json('specifications');
            $table->string('image')->default('http://placehold.co/400x400/8d6e63/FFFFFF?text=NO+IMAGE');
            $table->text('gallery')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
