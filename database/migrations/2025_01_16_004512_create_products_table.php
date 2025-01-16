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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->timestamps();

        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('products_name');
            $table->foreignId('product_type_id')
                ->references('id')
                ->on ('product_types')
                ->constrained();
            $table->text('description');
            $table->integer('stock');
            $table->double('price');
            $table->string('img_url'); // e.g.
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
