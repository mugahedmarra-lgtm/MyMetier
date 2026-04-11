<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class YemenLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clean existing location data first in safe order
        Schema::disableForeignKeyConstraints();
        District::truncate();
        City::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Read the internal JSON file
        $filePath = database_path('data/yemen-locations.json');
        if (!File::exists($filePath)) {
            $this->command->error("Internal location data file missing: {$filePath}. Project is no longer relying on external desktop files.");
            return;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        // Safety validation
        if (json_last_error() !== JSON_ERROR_NONE || empty($data['governorates']) || !is_array($data['governorates'])) {
            $this->command->error("Invalid internal JSON file schema or missing 'governorates' array in {$filePath}.");
            return;
        }

        $insertedCities = 0;
        $insertedDistricts = 0;

        // 3. Insert governorates into cities
        foreach ($data['governorates'] as $gov) {
            $govName = trim($gov['name_ar']);

            $city = City::create([
                'name' => $govName,
                'is_active' => true,
                'sort_order' => 0,
            ]);
            $insertedCities++;

            // 4. Insert districts into districts
            if (!empty($gov['districts'])) {
                foreach ($gov['districts'] as $dist) {
                    $distName = trim($dist['name_ar']);

                    // Normalization rule
                    $expectedPattern = 'مدينة ' . $govName;
                    if ($distName === $expectedPattern) {
                        $distName = 'المدينة';
                    }

                    District::create([
                        'city_id' => $city->id,
                        'name' => $distName,
                        'is_active' => true,
                        'sort_order' => 0,
                    ]);
                    $insertedDistricts++;
                }
            }
        }
        
        $this->command->info("Yemen Locations Seeded: $insertedCities Governorates, $insertedDistricts Districts.");
    }
}
