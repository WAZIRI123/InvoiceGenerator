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
      // Recurring
      Schema::create('recurring', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('company_id');
        $table->morphs('recurable');
        $table->string('frequency');
        $table->integer('interval')->default(1);
        $table->dateTime('started_at');
        $table->string('status')->default('active');
        $table->string('limit_by')->default('count');
        $table->integer('limit_count')->default(0);
        $table->dateTime('limit_date')->nullable();
        $table->boolean('auto_send')->default(1);
        $table->unsignedInteger('created_by')->nullable();
        $table->string('created_from', 100)->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->index('company_id');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
