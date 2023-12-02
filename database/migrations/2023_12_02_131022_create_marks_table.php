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
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('academic_year_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('registration_id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('subject_id');
            $table->text('marks');
            $table->integer('total_marks');
            $table->string('grade');
            $table->decimal('point',5,2);
            $table->enum('present',[0,1])->default(1);
     
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->unique(['class_id','exam_id','student_id', 'subject_id']);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
