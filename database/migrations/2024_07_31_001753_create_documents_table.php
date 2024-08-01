<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('org_file');
            $table->string('doc_file_name')->nullable();
            $table->string('preview')->nullable();
            $table->date('issued_on');
            $table->integer('contact_id')->default(0);
            $table->text('fulltext');
            $table->string('subject');
            $table->integer('size');
            $table->date('received_on')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
