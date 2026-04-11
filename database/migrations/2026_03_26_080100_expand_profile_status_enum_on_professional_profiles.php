<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Note: profile_status is stored as a string in SQLite (no real enum constraint).
     * The expanded values ('pending_review', 'rejected') are enforced at the application level
     * via the ProfessionalProfile model and UpgradePage validation.
     * Only the admin_notes column is actually added here.
     */
    public function up(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('profile_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });
    }
};
