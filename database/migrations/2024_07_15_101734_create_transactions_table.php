<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('mm_ref');
            $table->integer('contact_id');
            $table->integer('bank_account_id');
            $table->date('valued_on');
            $table->date('booked_on')->nullable();
            $table->text('comment')->nullable();
            $table->string('currency');
            $table->string('booking_key')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('name');
            $table->string('purpose')->nullable();
            $table->float('amount');
            $table->float('amount_EUR');
            $table->boolean('is_private')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
