<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookkeeping_bookings', function (Blueprint $table) {
            $table->year('document_number_year');
            $table->morphs('bookable');
            $table->boolean('is_marked')->default(false);
            $table->dropUnique('document_number');
            $table->unique(['document_number_year', 'document_number_prefix', 'document_number_counter'], 'document_number');
        });
    }

    public function down(): void
    {
        Schema::table('bookkeeping_bookings', function (Blueprint $table) {
            $table->dropColumn('document_number_year');
        });
    }
};
