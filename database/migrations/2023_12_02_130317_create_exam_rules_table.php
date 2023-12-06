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
        Schema::create('exam_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('combine_subject_id')->nullable();
            $table->text('marks_distribution');
            $table->enum('passing_rule',[1,2,3])->default(1); //1= Over All, 2=Individual, 3= Both
            $table->integer('total_exam_marks')->default(0);
            $table->integer('over_all_pass')->default(0);
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('combine_subject_id')->references('id')->on('subjects');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_rules');
    }
};
