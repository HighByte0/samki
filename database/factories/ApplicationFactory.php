<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\MainJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = \App\Models\Application::class;

    public function definition()
    {
        return [
            'email' => $this->faker->safeEmail,
            'nom' => $this->faker->name(),
            'prenom' => $this->faker->name(),
            'slug' => $this->faker->name(),
           'sexe' => $this->faker->randomElement(['Homme', 'Femme']),
           'telephone' => substr(preg_replace('/[^0-9]/', '', $this->faker->phoneNumber), 0, 10),
           'ville' => $this->faker->city,
           'experience' => $this->faker->randomElement(['oui', 'non']),

            'status_id' =>rand(1,5),
            'cv' => $this->faker->randomElement(['http://localhost:8000/files/applications/default.pdf']),
            'job_id' => $this->faker->randomElement(MainJob::where('status', 'active')->pluck('id')->toArray()),
          'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1,
        ];
    }
}
