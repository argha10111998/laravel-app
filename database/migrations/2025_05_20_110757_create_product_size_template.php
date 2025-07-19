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
        Schema::create('product_size', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('product')->onDelete('cascade');
            $table->foreignId('size_id')->constrained('size')->onDelete('cascade');
            $table->integer('stock')->default(0);
            $table->string('sku')->nullable();
            $table->decimal('price', 10, 2)->nullable();   
            $table->timestamps();
            $table->unique(['product_id', 'size_id']); // avoids duplicate entries
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_size'); // Fixed this - was 'product_size_template'
    }
};