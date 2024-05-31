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
    Schema::create('safety_instruction_categories', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('description')->default('');
      $table->string('color')->default('');
      $table->boolean('use_parent_interval')->default(true);
      $table->integer('interval')->default(365);
      $table->integer('number_of_intervals')->default(1);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('safety_instruction_categories');
  }
};
