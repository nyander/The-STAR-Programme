<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientGoal>
 */
class ClientGoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Randomly choose a type for the goal
        $type = $this->faker->randomElement(['amount', 'milestone']);
        
        // Set the goal value based on the type
        $goal = $type === 'amount' 
            ? $this->faker->randomNumber(5)  // Example: Amount in the form of random numbers up to 5 digits
            : $this->faker->word;           // Example: Milestone as a random word

        return [
            'description' => $this->faker->paragraph,
            'type' => $type,
            'goal' => $goal,
            'complete' => $this->faker->boolean,
            'client_id' => User::factory(), // Assuming you have a factory for the User model
        ];
    }
}
