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
        Schema::create('profs', function (Blueprint $table) {
            $table->id(); // Primary key 'id'
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->integer('prof_number')->unique(); // Column 'prof_number'
            $table->integer('nip')->unique(); // Column 'nip'
            $table->string('name'); // Column 'name'
            $table->timestamps(); // Columns 'created_at' and 'updated_at'
        });

        Schema::table('classlists', function (Blueprint $table) {
            $table->foreignId('prof_id')->nullable()->constrained('profs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classlists', function (Blueprint $table) {
            $table->dropForeign(['prof_id']);
            $table->dropColumn('prof_id');
        });
        Schema::dropIfExists('profs');
    }
};

