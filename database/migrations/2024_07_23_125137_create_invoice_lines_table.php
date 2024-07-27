<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->float('quantity')->nullable();
            $table->text('unit')->nullable();
            $table->text('text');
            $table->float('price')->nullable();
            $table->float('amount')->nullable();
            $table->float('tax')->nullable();
            $table->integer('tax_id');
            $table->integer('type_id')->default(0);
            $table->integer('pos');
            $table->integer('legacy_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_lines');
    }
};
