<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookkeeping_accounts', function (Blueprint $table) {
            $table->integer('tax_id')->default(4);
        });
    }

    public function down(): void
    {
        Schema::table('bookkeeping_accounts', function (Blueprint $table) {
            $table->dropColumn('tax_id');
        });
    }
};
