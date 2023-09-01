<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase; 

class RegistrationTest extends TestCase  
{

    use RefreshDatabase;

    /**
     * @test
     * @return void
    */
    public function test_validation_rules_applied_on_registration()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'abcd'
        ]);

        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors('password');

        
        
        

        
        $this->assertDatabaseMissing('users', [
            'email' => 'invalid-email'
        ]);
    }

    /**
     * @test
     * @return void
    */
    public function test_unique_email_validation()
    {
        // Existing user
        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->post('/register', [
             'email' => 'test@example.com'
        ]);

        $response->assertSessionHasErrors(['email' => 'The email has already been taken.']);
    }

    /**
    * @test
    * @return void
    */
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password1234',
            'password_confirmation' => 'password1234'
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

}