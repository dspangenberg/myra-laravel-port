<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookkeeping_logs', function (Blueprint $table) {
            $table->id();
            $table->string('parent_model');
            $table->string('parent_id');
            $table->text('text');
            $table->timestamps(); //
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookkeeping_logs');
    }
};
