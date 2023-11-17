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
        Schema::create('unit_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cts_unit_id'); 
            $table->integer('cts_division_id');
            $table->integer('cts_unit_division_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_divisions');
    }
};
