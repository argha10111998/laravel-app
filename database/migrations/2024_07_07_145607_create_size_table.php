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
        Schema::create('size', function (Blueprint $table) {
            $table->id();
            $table->string('size')->unique();
            $table->timestamps();
        });

        // Pivot table to link products and sizes
        Schema::create('product_size', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('size_id');
            $table->decimal('price');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('size')->onDelete('cascade');

            $table->unique(['product_id', 'size_id']); // Ensure uniqueness
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_size');
        Schema::dropIfExists('size');
    }
};
