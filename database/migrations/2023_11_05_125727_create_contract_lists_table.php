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
        Schema::create('contract_lists', function (Blueprint $table) {
            $table->id();
            $table->decimal('price');
            // Same thing as with price lists
            $table->string('sku', 64);
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_lists');
    }
};
