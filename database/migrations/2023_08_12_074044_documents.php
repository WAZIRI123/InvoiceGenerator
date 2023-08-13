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
     // Documents
     Schema::create('documents', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('company_id');
        $table->string('type');
        $table->string('document_number');
        $table->string('order_number')->nullable();
        $table->string('status');
        $table->dateTime('issued_at');
        $table->dateTime('due_at');
        $table->double('amount', 15, 4);
        $table->string('currency_code');
        $table->double('currency_rate', 15, 8);
        $table->unsignedInteger('category_id')->default(1);
        $table->unsignedInteger('contact_id');
        $table->string('contact_name');
        $table->string('contact_email')->nullable();
        $table->string('contact_tax_number')->nullable();
        $table->string('contact_phone')->nullable();
        $table->text('contact_address')->nullable();
        $table->string('contact_city')->nullable();
        $table->string('contact_zip_code')->nullable();
        $table->string('contact_state')->nullable();
        $table->string('contact_country')->nullable();
        $table->text('notes')->nullable();
        $table->text('footer')->nullable();
        $table->unsignedInteger('parent_id')->default(0);
        $table->string('created_from', 100)->nullable();
        $table->unsignedInteger('created_by')->nullable();
        $table->timestamps();
        $table->softDeletes();

        $table->index('contact_id');
        $table->index('company_id');
        $table->index('type');
        
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
