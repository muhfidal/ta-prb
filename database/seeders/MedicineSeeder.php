<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Faker\Factory as Faker;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Medicine::create([
                'name' => $faker->word,
                'code' => $faker->unique()->numerify('MED###'),
                'description' => $faker->sentence,
                'unit' => $faker->randomElement(['tablet', 'capsule', 'bottle']),
            ]);
        }
    }
}
