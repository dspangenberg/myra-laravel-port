<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_suggestions', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_id');
            $table->string('transaction_id');
            $table->integer('confidence');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_suggestions');
    }
};
