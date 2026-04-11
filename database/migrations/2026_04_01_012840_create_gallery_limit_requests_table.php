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
        Schema::create('gallery_limit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_profile_id')->constrained('professional_profiles')->cascadeOnDelete();
            $table->integer('requested_limit');
            $table->string('payment_proof_path');
            $table->string('status')->default('pending_review')->index();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_limit_requests');
    }
};
