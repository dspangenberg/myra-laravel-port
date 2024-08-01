<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->integer('number_of_pages')->default(0);
            $table->integer('subject')->change()->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('is_marked')->default(false);
            $table->string('sender')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('number_of_pages');
            $table->dropColumn('is_confirmed');
            $table->dropColumn('is_marked');
        });
    }
};
