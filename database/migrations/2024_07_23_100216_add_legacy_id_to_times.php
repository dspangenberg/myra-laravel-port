<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('times', function (Blueprint $table) {
            $table->integer('legacy_id')->default(0);
            $table->integer('legacy_invoice_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('times', function (Blueprint $table) {
            $table->dropColumn('legacy_id');
            $table->dropColumn('legacy_invoice_id');
        });
    }
};