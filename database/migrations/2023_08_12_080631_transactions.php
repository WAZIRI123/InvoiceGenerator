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
 // Transactions
 Schema::create('transactions', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('company_id');
    $table->string('type');
    $number = $table->string('number');
    $table->dateTime('paid_at');
    $table->double('amount', 15, 4);
    $table->string('currency_code');
    $table->double('currency_rate', 15, 8);
    $table->integer('account_id');
    $table->integer('document_id')->nullable();
    $table->integer('contact_id')->nullable();
    $table->integer('category_id')->default(1);
    $table->text('description')->nullable();
    $table->string('payment_method');
    $table->string('reference')->nullable();
    $table->integer('parent_id')->default(0);
    $table->unsignedInteger('split_id')->nullable();
    $table->foreign('split_id')->references('id')->on('transactions');
    $table->boolean('reconciled')->default(0);
    $table->string('created_from', 100)->nullable();
    $table->unsignedInteger('created_by')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index('number');
    $table->index(['company_id', 'type']);
    $table->index('account_id');
    $table->index('category_id');
    $table->index('contact_id');
    $table->index('document_id');
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
