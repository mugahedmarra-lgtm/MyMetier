<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_request_id')->constrained()->cascadeOnDelete();
            $table->string('document_type'); // commercial_register, vocational_license, national_id, other
            $table->string('file_path', 500);
            $table->string('original_filename')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_documents');
    }
};
