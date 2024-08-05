<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'amount_EUR')) {
                $table->dropColumn('amount_EUR');
            }
            $table->float('amount_in_foreign_currency')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('amount_in_foreign_currency');
        });
    }
};
