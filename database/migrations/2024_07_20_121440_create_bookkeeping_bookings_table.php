<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookkeeping_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->default(0);
            $table->integer('receipt_id')->default(0);
            $table->integer('payment_id')->default(0);
            $table->integer('account_id_credit')->default(0);
            $table->string('account_id_debit')->default(0);
            $table->float('amount')->default(0);
            $table->date('date');
            $table->integer('tax_id')->default(0);
            $table->boolean('is_split')->default(false);
            $table->integer('split_id')->default(0);
            $table->string('booking_text');
            $table->string('document_number');
            $table->text('note')->nullable();
            $table->float('tax_credit')->default(0);
            $table->float('tax_debit')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookkeeping_bookings');
    }
};
