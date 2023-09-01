<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientEnquiry>
 */
class ClientEnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'client_id' => \App\Models\User::factory(),  // Assuming you have a User factory.
            'content' => $this->faker->paragraph,
            'subject' => $this->faker->text(50),
            'resolved' => false
        ];
    }
}
