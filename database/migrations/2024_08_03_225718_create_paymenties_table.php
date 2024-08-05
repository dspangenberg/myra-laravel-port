<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('payments');
        Schema::create('payments', function (Blueprint $table) {

            $table->id();
            $table->morphs('payable');
            $table->integer('booking_id')->default(0);
            $table->integer('transaction_id');
            $table->float('amount');
            $table->boolean('is_private')->default(false);
            $table->date('issued_on');
            $table->boolean('is_confirmed')->default(false);
            $table->integer('rank')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paymenties');
    }
};
