<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class extends Migration {
    public function up(): void
    {
        Schema::table('receipt_category', function (Blueprint $table) {
            $table->string('type', 1)->default('O');
            $table->boolean('is_private')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('receipt_category', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('is_private');
        });
    }
};