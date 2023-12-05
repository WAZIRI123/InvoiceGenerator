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
            $table->unsignedInteger('classes_id');
            $table->string('name');
            $table->decimal('elective_subject_point_addition',5,2)->default(0.00);
            $table->text('marks_distribution_types');
            $table->enum('status', [0,1])->default(1);
            $table->boolean('open_for_marks_entry')->default(false);

            $table->foreign('classes_id')->references('id')->on('classes');

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
