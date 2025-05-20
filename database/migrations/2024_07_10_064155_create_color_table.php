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
        Schema::create('color', function (Blueprint $table) {
            $table->id();
            $table->string('color')->unique();
            $table->string('color_code')->unique();
            $table->timestamps();
        });

        // Pivot table to link products and sizes
        // Schema::create('product_color', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('product_id');
        //     $table->unsignedBigInteger('color_id');
        //     $table->timestamps();

        //     $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        //     $table->foreign('color_id')->references('id')->on('color')->onDelete('cascade');
        // });
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
