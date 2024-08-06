<?php

use App\Models\NumberRangeDocumentNumbers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->foreignId('number_range_document_numbers_id')->constrained()->cascadeOnDelete();
            $table->unique('number_range_document_numbers_id');
        });
    }

    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropForeignIdFor(NumberRangeDocumentNumbers::class);
            $table->dropUnique('invoices_number_range_document_numbers_id_unique');
        });
    }
};
