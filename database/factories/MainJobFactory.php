<?php

namespace Database\Factories;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\Factory;

class MainJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'title' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'salary' => $this->faker->randomFloat(2, 1000, 10000),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'profil' => json_encode(['Émission', 'Réception', 'Back office', 'Cadre', 'Télétravail']),
            'job_description' => $this->faker->paragraphs(3, true),
            'profile_description' => $this->faker->paragraphs(2, true),
            'experience' => $this->faker->boolean,
            'other_information' => $this->faker->paragraph,
            'languages' => json_encode(['Arabic', 'English', 'French']),
            'working_hours' => $this->faker->randomElement(['Full-time', 'Part-time', 'Flexible']),
            'email' => $this->faker->companyEmail,
            'site' => $this->faker->url,
            'user_id' => 1, // Adjust as needed
           'created_at' => now(),
            'updated_at' => now(),
            // 'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            // 'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
