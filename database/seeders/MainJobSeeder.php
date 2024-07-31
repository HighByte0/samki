<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate dummy data using Faker
        $faker = \Faker\Factory::create();

        // Define an array to hold job data
        $jobs = [];

        // Generate 10 job records
        for ($i = 0; $i < 10; $i++) {
            $jobs[] = [
                'title' => $faker->jobTitle,
                'company' => $faker->company,
                'salary' => $faker->randomFloat(2, 1000, 10000),
                'description' => $faker->paragraph,
                'status' => $faker->randomElement(['active', 'inactive']),
                'profil' => json_encode(['Émission', 'Réception', 'Back office', 'Cadre', 'Télétravail']),
                'job_description' => $faker->paragraphs(3, true),
                'profile_description' => $faker->paragraphs(2, true),
                'experience' => $faker->boolean,
                'other_information' => $faker->paragraph,
                'languages' => json_encode(['Arabic', 'English', 'French']), // Example languages
                'working_hours' => $faker->randomElement(['Full-time', 'Part-time', 'Flexible']),
                'email' => $faker->companyEmail,
                'site' => $faker->url,
                'user_id' => 1, // Replace with a valid user_id
           
            ];
        }

        // Insert all jobs into the database
        DB::table('main_jobs')->insert($jobs);
    }
}
