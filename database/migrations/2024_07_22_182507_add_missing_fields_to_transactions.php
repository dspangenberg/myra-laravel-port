<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('booking_text')->nullable();
            $table->string('type')->nullable();
            $table->string('return_reason')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('end_to_end_reference')->nullable();
            $table->string('mandate_reference')->nullable();
            $table->string('batch_reference')->nullable();
            $table->string('primanota_number')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('booking_text');
            $table->dropColumn('type');
            $table->dropColumn('return_reason');
            $table->dropColumn('transaction_code');
            $table->dropColumn('mandate_reference');
            $table->dropColumn('end_to_end_reference');
            $table->dropColumn('batch_reference');
            $table->dropColumn('primanota_number');
        });
    }
};
