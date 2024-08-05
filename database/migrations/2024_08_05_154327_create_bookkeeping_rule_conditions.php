<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookkeeping_rule_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bookkeeping_rule_id')->constrained()->cascadeOnDelete();
            $table->integer('priority')->default(10);
            $table->enum('table', ['transactions', 'documents', 'payments', 'receipts', 'bookings', 'mm_import', 'receipts_import']);
            $table->string('field');
            $table->string('logical_condition')->default('=');
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookkeeping_rule_conditions');
    }
};
