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
        Schema::create('price_list_product', function (Blueprint $table) {
            $table->foreignId('price_list_id')->references('id')->on('price_lists');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->primary(['price_list_id', 'product_id']);
            $table->string('name');
            $table->string('price');
            $table->string('sku', 64);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_list_product');
    }
};
