<?php

use App\Models\NumberRangeDocumentNumbers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookkeeping_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookkeeping_bookings', 'document_number_prefix')) {
                $table->dropColumn('document_number_prefix');
            }

            if (Schema::hasColumn('bookkeeping_bookings', 'document_number_counter')) {
                $table->dropColumn('document_number_counter');
            }

            if (Schema::hasColumn('bookkeeping_bookings', 'document_number_year')) {
                $table->dropColumn('document_number_year');
            }
            // $table->foreignId('number_range_document_numbers_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookkeeping_bookings', function (Blueprint $table) {
            $table->dropForeignIdFor(NumberRangeDocumentNumbers::class);
        });
    }
};
