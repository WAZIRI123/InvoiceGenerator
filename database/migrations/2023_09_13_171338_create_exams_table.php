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
        Schema::create('exams', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('slug')->unique();

            $table->foreignId('classes_id')->constrained()->onDelete('cascade');

            $table->foreignId('semester_id')->constrained()->onDelete('cascade');

            $table->foreignId('subject_id')->constrained()->onDelete('cascade');

            $table->text('description');

            $table->timestamp('start_date');

            $table->timestamp('end_date');

            $table->softDeletes();

            $table->timestamps();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
