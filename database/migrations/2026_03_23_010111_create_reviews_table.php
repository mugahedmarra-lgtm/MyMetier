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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professional_profile_id')->constrained()->cascadeOnDelete();
            $table->integer('rating'); // 1 to 5
            $table->text('comment')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // One user can only have ONE review per professional
            $table->unique(['user_id', 'professional_profile_id']);
            
            // Note: DB constraint for rating (1 to 5)
            // While PostgreSQL and SQLite support CHECK constraints neatly,
            // standard Laravel cross-database way is trusting application validation.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
