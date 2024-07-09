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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipts_ref');
            $table->string('reference');
            $table->integer('receipt_category_id');
            $table->integer('contact_id');
            $table->date('issued_on');
            $table->integer('tax_rate')->default(0);
            $table->float('amount')->default(0);
            $table->string('currency_code');
            $table->float('exchange_rate')->default(0);
            $table->float('gross')->default(0);
            $table->float('net')->default(0);
            $table->float('tax')->default(0);
            $table->string('title')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('export_file_name')->nullable();
            $table->string('text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
