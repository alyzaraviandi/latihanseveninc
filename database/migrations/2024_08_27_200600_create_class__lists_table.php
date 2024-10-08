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
        Schema::create('classlists', function (Blueprint $table) {
            $table->id(); // Primary key 'id'
            $table->string('name'); // Column 'name' (string)
            $table->string('class_id')->unique();
            $table->integer('sum'); // Column 'jumlah' (integer)
            $table->timestamps(); // Columns 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classlists');
    }
};
