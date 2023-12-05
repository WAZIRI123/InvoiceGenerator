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
        Schema::create('result_publishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('classes_id');
            $table->unsignedBigInteger('exam_id');
            // Add other necessary columns if needed

            // Foreign keys
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->foreign('classes_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_publishes');
    }
};
