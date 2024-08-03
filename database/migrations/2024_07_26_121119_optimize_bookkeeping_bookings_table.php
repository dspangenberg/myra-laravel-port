<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableName = 'bookkeeping_bookings';

    public function up(): void
    {

        Schema::table($this->tableName, function (Blueprint $table) {
            $table->morphs('bookable');
            $table->boolean('is_marked')->default(false);

            if (Schema::hasColumn($this->tableName, 'transaction_id')) {
                $table->dropColumn('transaction_id');
                $table->dropColumn('receipt_id');
                $table->dropColumn('payment_id');
            }

            if (Schema::hasColumn($this->tableName, 'document_number')) {
                $table->dropColumn('document_number');
            }

            $table->year('document_number_year');
            $table->string('document_number_prefix');
            $table->integer('document_number_counter');

            $table->unique(['document_number_year', 'document_number_prefix', 'document_number_counter'], 'document_number');
        });
    }

    public function down(): void
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropMorphs('bookable');
            $table->dropColumn('is_marked');
            $table->dropColumn('document_number_year');
            $table->dropColumn('document_number_prefix');
            $table->dropColumn('document_number_counter');
        });
    }
};
