<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wishlist_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('frontend_user_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->unique(['frontend_user_id', 'product_id'], 'wishlist_unique');

            $table->foreign('frontend_user_id')
                  ->references('id')->on('frontend_users')
                  ->cascadeOnDelete();
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('wishlist_items');
    }
};
