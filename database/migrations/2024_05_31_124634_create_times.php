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
        Schema::create('times', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('time_category_id');
            $table->integer('subproject_id')->default(0);
            $table->integer('task_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->integer('invoice_id')->default(0);

            $table->text('note');

            $table->timestamp('begin_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->boolean('is_locked')->default(false);
            $table->boolean('is_billable')->default(true);
            $table->boolean('is_timer')->default(false);

            $table->integer('minutes');
            $table->date('dob')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('ping_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('times');
    }
};
