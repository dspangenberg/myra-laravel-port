<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('prefix', 3)->default('PBG');
            $table->integer('document_number')->nullable();
            $table->integer('year');
            $table->unique(['year', 'prefix', 'document_number'], 'document_number');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropUnique('document_number');
            $table->dropColumn('prefix');
            $table->dropColumn('document_number');
            $table->dropColumn('year');
        });
    }
};
