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
        Schema::create('professional_galleries', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('professional_profile_id')->constrained()->cascadeOnDelete();
            
            $table->string('image_path');
            $table->string('title')->nullable();
            
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_galleries');
    }
};
