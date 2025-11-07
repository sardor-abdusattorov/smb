<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('frontend_user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('color', 64)->nullable();    // rangi
            $table->string('size', 64)->nullable();     // razmeri
            $table->string('material', 64)->nullable(); // materiali
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();

            // Bitta foydalanuvchi uchun bitta kombinatsiya unikal
            $table->unique([
                'frontend_user_id','product_id','color','size','material'
            ], 'uniq_user_product_opts');
            
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }
    public function down(): void {
        Schema::dropIfExists('cart_items');
    }
};
