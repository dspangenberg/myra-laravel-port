<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receipt', function (Blueprint $table) {
            $table->boolean('is_locked')->default(false);
            $table->text('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('receipt', function (Blueprint $table) {
            $table->dropColumn('is_locked');
            $table->dropColumn('note');
        });
    }
};
