<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receipt_categories', function (Blueprint $table) {
            $table->integer('outturn_account_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('receipt_categories', function (Blueprint $table) {
            $table->dropColumn('outturn_account_id');
        });
    }
};
