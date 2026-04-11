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
            $table->enum('provider_type', ['professional', 'contractor'])->nullable()->after('user_id')->index();
            $table->string('secondary_phone', 20)->nullable()->after('whatsapp_number');
            $table->enum('gender', ['male', 'female'])->nullable()->after('secondary_phone');
            $table->string('identity_number', 20)->nullable()->after('gender');
            $table->string('identity_image_path', 500)->nullable()->after('identity_number');
            $table->boolean('identity_image_public_visible')->default(false)->after('identity_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_profiles', function (Blueprint $table) {
            $table->dropIndex(['provider_type']);
            $table->dropColumn([
                'provider_type',
                'secondary_phone',
                'gender',
                'identity_number',
                'identity_image_path',
                'identity_image_public_visible',
            ]);
        });
    }
};
