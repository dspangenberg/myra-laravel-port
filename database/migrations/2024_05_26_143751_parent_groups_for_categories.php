<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::table('eqquipment_categories', function (Blueprint $table) {
        $table->renameColumn('eqquipment_group_id', 'parent_id')->default(0);
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('eqquipment_categories', function (Blueprint $table) {
        $table->renameColumn('parent_id', 'eqquipment_group_id');
      });
    }
};
