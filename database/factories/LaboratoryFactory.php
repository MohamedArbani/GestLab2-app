<?php

namespace Database\Factories;

use App\Models\Laboratory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laboratory>
 */
class LaboratoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     
     * public function definition(): array
    * {
     *   return [
     *     //
     *  ];
    * }
    **/

    protected $model = Laboratory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company, // Génère un nom d'entreprise
            'address' => $this->faker->address, // Génère une adresse
            'phone' => $this->faker->phoneNumber, // Génère un numéro de téléphone
            'latitude' => $this->faker->latitude, // Génère une latitude
            'longitude' => $this->faker->longitude, // Génère une longitude
        ];
    }


}
