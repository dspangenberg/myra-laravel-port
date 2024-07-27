<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('is_transit')->default(false);
            $table->foreignId('booking_id')->nullable()->constrained('bookkeeping_bookings');

            if (Schema::hasColumn('transactions', 'year')) {
                $table->dropColumn('document_number');
                $table->dropColumn('year');
                $table->dropUnique('document_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('is_transit');
            $table->dropForeignIdFor(Transaction::class, 'booking_id');
        });
    }
};
