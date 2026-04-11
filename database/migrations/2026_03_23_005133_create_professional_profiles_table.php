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
        Schema::create('professional_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->foreignId('district_id')->constrained()->cascadeOnDelete();
            
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('whatsapp_number');
            
            $table->enum('availability_status', ['available', 'busy', 'offline'])->default('available');
            $table->enum('verification_status', ['unverified', 'verified'])->default('unverified');
            $table->enum('profile_status', ['active', 'inactive', 'suspended'])->default('active');
            
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            
            $table->integer('views_count')->default(0);
            $table->integer('whatsapp_clicks')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_profiles');
    }
};
