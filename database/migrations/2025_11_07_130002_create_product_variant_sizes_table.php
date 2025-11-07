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
        Schema::create('product_variant_sizes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete();

            $table->foreignId('size_id')
                ->constrained('product_sizes')
                ->cascadeOnDelete();

            $table->integer('stock')->default(0)->comment('Quantity in stock');
            $table->string('dimensions')->nullable()->comment('e.g. 30x40x15 cm');
            $table->string('sku')->nullable()->comment('Stock keeping unit');

            $table->boolean('status')->default(true);
            $table->unsignedInteger('sort')->default(0);

            $table->timestamps();

            // Ensure unique combination of variant + size
            $table->unique(['variant_id', 'size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_sizes');
    }
};
