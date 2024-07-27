<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id');
            $table->integer('project_id');
            $table->integer('invoice_number')->default(0);
            $table->date('issued_on');
            $table->date('due_on');
            $table->boolean('dunning_block')->default(false);
            $table->boolean('is_draft')->default(false);
            $table->integer('type_id');
            $table->string('service_provision');
            $table->string('vat_id');
            $table->text('address');
            $table->integer('payment_deadline_id');
            $table->dateTime('sent_at')->nullable();
            $table->integer('legacy_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
