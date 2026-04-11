<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\City;
use App\Models\District;
use App\Models\ProfessionalProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['phone' => '000000000'],
            [
                'name' => 'Admin Manager',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // 2. Customer User
        $customer = User::firstOrCreate(
            ['phone' => '0500000001'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'status' => 'active',
            ]
        );

        // 3. Professional User
        $proUser = User::firstOrCreate(
            ['phone' => '0500000002'],
            [
                'name' => 'Professional User',
                'password' => Hash::make('password'),
                'role' => 'professional',
                'status' => 'active',
            ]
        );

        // 4. Categories
        $cat1 = Category::firstOrCreate(['name' => 'سباكة'], ['icon' => 'heroicon-o-wrench', 'is_active' => true, 'sort_order' => 1]);
        $cat2 = Category::firstOrCreate(['name' => 'كهرباء'], ['icon' => 'heroicon-o-bolt', 'is_active' => true, 'sort_order' => 2]);
        $cat3 = Category::firstOrCreate(['name' => 'نجارة'], ['icon' => 'heroicon-o-scissors', 'is_active' => true, 'sort_order' => 3]);

        // 5. Locations (Cities and Districts)
        $this->call(YemenLocationsSeeder::class);

        $city1 = City::first();
        $dist1 = District::where('city_id', $city1->id)->first();

        // 6. Professional Profile
        ProfessionalProfile::firstOrCreate(
            ['user_id' => $proUser->id],
            [
                'provider_type' => 'professional',
                'category_id' => $cat1->id,
                'city_id' => $city1->id,
                'district_id' => $dist1->id,
                'display_name' => 'أحمد للسباكة العامة',
                'description' => 'متخصص في جميع أعمال السباكة المنزلية والتجارية بخبرة تزيد عن 10 سنوات.',
                'whatsapp_number' => '966500000002',
                'availability_status' => 'available',
                'verification_status' => 'verified',
                'profile_status' => 'active',
                'rating_avg' => 4.5,
                'rating_count' => 12,
            ]
        );
    }
}
