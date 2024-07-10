<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('type', 1)->default('A');
            $table->integer('document_number')->nullable();
            $table->integer('year');
            $table->unique(['year', 'type', 'document_number' ],'document_number');
        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('document_number');
            $table->dropColumn('year');
            $table->dropUnique('document_number');
        });
    }
};
