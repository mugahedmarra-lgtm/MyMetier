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
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
        });

        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->nullable()->change();
            $table->foreign('district_id')
                  ->references('id')
                  ->on('districts')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
        });

        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->nullable(false)->change();
            $table->foreign('district_id')
                  ->references('id')
                  ->on('districts')
                  ->cascadeOnDelete();
        });
    }
};
