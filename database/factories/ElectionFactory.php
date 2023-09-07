<?php

namespace Database\Factories;

use App\Models\Election;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectionFactory extends Factory
{
    protected $model = Election::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->randomElement(['President', 'Vice President', 'Secretary', 'Assistant Secretary', 'PRO']),
            'start' => now()->addDay(),
            'end' => now()->addDays(2),
            'status' => 'open',
        ];
    }
}
