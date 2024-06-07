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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->default(0);
            $table->boolean('is_org')->default(false);

            $table->string('name');
            $table->integer('title_id')->default(0);
            $table->integer('salutation_id')->default(0);
            $table->string('first_name')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();

            $table->string('short_name')->nullable();
            $table->string('ref')->nullable();

            $table->integer('catgory_id')->default(0);

            $table->boolean('is_debtor')->default(false);
            $table->boolean('is_creditor')->default(false);
            $table->integer('debtor_number')->nullable();
            $table->integer('creditor_number')->nullable();

            $table->boolean('is_archived')->default(false);
            $table->string('archived_reason')->nullable();

            $table->boolean('has_dunning_block')->default(false);
            $table->integer('payment_deadline_id')->default(0);
            $table->integer('tax_id')->default(0);
            $table->decimal('hourly')->default(0);
            $table->string('register_court')->nullable();
            $table->string('register_number')->nullable();
            $table->string('vat_id')->nullable();
            $table->string('website')->nullable();
            $table->text('note')->nullable();
            $table->date('dob')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
