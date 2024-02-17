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
        Schema::create('case_types', function (Blueprint $table) {
            $table->id();
            $table->string('case_type_name', 250);
            $table->string('code');
            $table->string('category_name');
            $table->integer('cts_case_type_id'); 
            $table->integer('cts_case_category_id'); 
            // $table->integer('cts_case_category_id'); 
            // $table->integer('cts_case_category_id'); 
            $table->integer('cts_unit_div_case_type_id'); 
            $table->integer('cts_unit_division_id'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_categories');
    }
};
