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
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // id integer unique
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->integer('student_number')->unique(); // nim integer unique
            $table->string('name'); // name string
            $table->string('place_of_birth'); // tempat_lahir string
            $table->date('date_of_birth'); // tanggal_lahir date
            $table->boolean('edit')->default(false); // edit boolean default value false
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
