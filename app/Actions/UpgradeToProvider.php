<?php

namespace App\Actions;

use App\Models\User;
use App\Models\ProfessionalProfile;
use App\Models\ContractorDetails;
use Illuminate\Support\Facades\DB;

class UpgradeToProvider
{
    /**
     * Execute the upgrade flow atomically.
     *
     * @param  User   $user      The authenticated user performing the upgrade.
     * @param  array  $data      Validated form data.
     * @param  string|null $identityImagePath  Path to stored identity image (already stored before calling).
     * @return ProfessionalProfile
     */
    public function execute(User $user, array $data, ?string $identityImagePath = null): ProfessionalProfile
    {
        return DB::transaction(function () use ($user, $data, $identityImagePath) {

            // 1. Update user core fields (name, phone).
            $user->update([
                'name'  => $data['name'],
                'phone' => $data['phone'],
            ]);

            // 2. Prepare professional profile data.
            $profileData = [
                'provider_type'               => $data['provider_type'],
                'display_name'                => $data['display_name'],
                'whatsapp_number'             => $data['whatsapp_number'],
                'secondary_phone'             => $data['secondary_phone'] ?? null,
                'category_id'                 => $data['category_id'],
                'city_id'                     => $data['city_id'],
                'district_id'                 => $data['district_id'] ?: null,
                'gender'                      => $data['gender'],
                'description'                 => $data['description'],
                'identity_number'             => $data['identity_number'],
                'identity_image_public_visible' => false,
                'availability_status'         => $data['availability_status'],
                'profile_status'              => 'pending_review',
                'verification_status'         => 'unverified',
            ];

            // Only overwrite identity_image_path if a new image was uploaded.
            if ($identityImagePath) {
                $profileData['identity_image_path'] = $identityImagePath;
            }

            // 3. Create or update professional profile.
            $profile = $user->professionalProfile;

            if ($profile) {
                // Resubmission after rejection — update existing record.
                $profile->update($profileData);
            } else {
                // First submission — create new record.
                $profile = $user->professionalProfile()->create($profileData);
            }

            // 4. Handle contractor extension data.
            if ($data['provider_type'] === 'contractor') {
                $contractorData = [
                    'business_name'    => $data['business_name'],
                    'contractor_type'  => $data['contractor_type'],
                    'team_size'        => $data['team_size'] ?? null,
                ];

                if ($profile->contractorDetails) {
                    $profile->contractorDetails->update($contractorData);
                } else {
                    $profile->contractorDetails()->create($contractorData);
                }
            }

            // 5. Update user role AFTER successful data persistence.
            $user->update([
                'role' => $data['provider_type'],
            ]);

            return $profile->fresh();
        });
    }
}
