<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('outturn_account_id')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->string('paypal_email')->nullable();
            $table->string('cc_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('outturn_account_id');
            $table->dropColumn('paypal_email');
            $table->dropColumn('is_primary');
            $table->dropColumn('cc_name');
        });
    }
};
