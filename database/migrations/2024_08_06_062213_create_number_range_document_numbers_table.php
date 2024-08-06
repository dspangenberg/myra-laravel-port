<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('number_range_document_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('number_range_id')->constrained()->cascadeOnDelete();
            $table->integer('year');
            $table->integer('counter');
            $table->string('document_number');
            $table->timestamps();
            $table->unique(['number_range_id', 'year', 'document_number'], 'document_number_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('number_range_document_numbers');
    }
};
