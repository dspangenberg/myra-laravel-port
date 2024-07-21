<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pay_pal_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->string('transaction_id');
            $table->string('paypal_reference_id');
            $table->string('paypal_reference_id_type');
            $table->string('transaction_event_code');
            $table->string('transaction_initiation_date');
            $table->string('transaction_updated_date');
            $table->float('transaction_amount');
            $table->string('transaction_currency');
            $table->string('transaction_status');
            $table->string('payer_name');
            $table->string('payer_email');
            $table->string('transaction_subject');
            $table->json('data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pay_pal_transactions');
    }
};
