<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookkeeping_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority')->default(10);
            $table->enum('logical_operator', ['and', 'or'])->default('or');
            $table->enum('table', ['transactions', 'documents', 'payments', 'receipts', 'bookings', 'mm_import', 'receipts_import']);
            $table->boolean('is_active');
            $table->enum('action_type', ['update', 'delete', 'ignore', 'batch_ignore'])->default('update');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookkeeping_rules');
    }
};
