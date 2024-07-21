<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('taxes', function (Blueprint $table) {
            $table->integer('account_input_tax')->default(0);
            $table->integer('account_vat')->default(0);
            $table->integer('tax_code_number')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('taxes', function (Blueprint $table) {
            $table->dropColumn('account_input_tax');
            $table->dropColumn('account_vat');
            $table->dropColumn('tax_code_number');
        });
    }
};
