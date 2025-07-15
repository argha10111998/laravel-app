<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('size', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Small, Medium, Large, etc.
            $table->string('code', 10)->nullable(); // S, M, L, XL, etc.
            $table->timestamps();
        });
        DB::table('size')->insert([
            ['name' => 'Small', 'code' => 'S'],
            ['name' => 'Medium', 'code' => 'M'],
            ['name' => 'Large', 'code' => 'L'],
            ['name' => 'Extra Large', 'code' => 'XL'],
        ]);

    }

    public function down()
    {
        Schema::dropIfExists('size');
    }
};