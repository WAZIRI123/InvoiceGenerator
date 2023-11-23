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
        Schema::create('grade_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->nullable()->constrained()->onDelete('cascade');
            $table->tinyInteger('mark_from');
            $table->tinyInteger('mark_to');
            $table->string('remark', 40);
            $table->timestamps();
        });

        Schema::table('grade_systems', function (Blueprint $table) {
            $table->unique(['mark_to', 'mark_from','exam_id', 'remark']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_systems');
    }
};
