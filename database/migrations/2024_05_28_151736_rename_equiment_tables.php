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
      Schema::rename('eqquipment_categories', 'equipment_categories');
      Schema::rename('eqquipment_groups', 'inventory_groups');
      Schema::rename('eqquipment_category_eqquipment_group', 'equipment_category_inventory_group');

      Schema::table('equipment_category_inventory_group', function (Blueprint $table) {
        $table->renameColumn('eqquipment_category_id', 'equipment_category_id');
        $table->renameColumn('eqquipment_group_id', 'inventory_group_id');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::rename('equipment_categories', 'eqquipment_categories');
      Schema::rename('equipment_category_inventory_group', 'eqquipment_category_eqquipment_group');
      Schema::table('equipment_category_inventory_group', function (Blueprint $table) {
        $table->renameColumn('equipment_category_id', 'eqquipment_category_id');
        $table->renameColumn('inventory_group_id', 'eqquipment_group_id');
      });
    }
};
