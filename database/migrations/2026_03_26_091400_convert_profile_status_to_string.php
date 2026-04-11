<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convert profile_status from ENUM to VARCHAR for MySQL/MariaDB portability.
     *
     * The original column was ENUM('active', 'inactive', 'suspended').
     * The upgrade flow now uses 'pending_review' and 'rejected' as well.
     * SQLite accepted those values silently, but MySQL/MariaDB would reject them.
     *
     * Solution: convert to string(20) with application-level validation.
     * Valid values: pending_review, active, inactive, suspended, rejected.
     */
    public function up(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->string('profile_status', 20)->default('active')->change();
        });
    }

    /**
     * Reverse: convert back to enum.
     * Note: any rows with 'pending_review' or 'rejected' should be handled first.
     */
    public function down(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->enum('profile_status', ['active', 'inactive', 'suspended'])->default('active')->change();
        });
    }
};
