<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_folders', function (Blueprint $table) {
            $table->string('path_structure');
            $table->string('file_name_structure');
        });
    }

    public function down(): void
    {
        Schema::table('document_folders', function (Blueprint $table) {
            $table->dropColumn('path_structure');
            $table->dropColumn('file_name_structure');
        });
    }
};
