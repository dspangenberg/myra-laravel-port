<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('number_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prefix');
            $table->string('model');
            $table->timestamps(); //
            $table->unique(['prefix']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('number_ranges');
    }
};
