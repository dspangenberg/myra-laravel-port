<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->float('amount_to_pay')->default(0);
            $table->string('text_md5')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('amount_to_pay');
            $table->dropColumn('text_md5');
        });
    }
};
