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
    // Items
    Schema::create('items', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('company_id');
        $table->string('type')->default('product');
        $table->string('name');
        $table->string('sku')->nullable();
        $table->text('description')->nullable();
        $table->double('sale_price', 15, 4)->nullable();
        $table->double('purchase_price', 15, 4)->nullable();
        $table->integer('category_id')->nullable();
        $table->boolean('enabled')->default(1);
        $table->unsignedInteger('created_by')->nullable();
        $table->string('created_from', 100)->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->index('company_id');
        
        $table->unique(['company_id', 'sku', 'deleted_at']);
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
