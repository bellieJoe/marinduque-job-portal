<?php

namespace Database\Factories;

use App\Models\Seeker;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeekerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seeker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            // 'user_id' => 1,
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->lastName,
            'lastname' => $this->faker->lastName,
        ];
    }
}
