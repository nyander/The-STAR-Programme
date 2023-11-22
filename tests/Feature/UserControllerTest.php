<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /**
     * Testing pagination and data view
     */

     public function testPaginationandViewData()
     {
        // Create multiple users
        User::factory()->count(15)->create();

        $admin = User::factory()->create();
        $roleAdmin = Role::create(['name' => 'Admin']);
        $admin->assignRole('Admin');

        $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertStatus(200)
        ->assertSee('pagination') //Check for any kind of pagination element on the page
        ->assertViewHas('data');  // Ensure 'data' variable is passed to the view 
     }

     public function testAccessLogicForDifferentRoles()
     {
        // Admin user
        $admin = User::factory()->create();
        $roleAdmin = Role::create(['name' => 'Admin']);
        $admin->assignRole('Admin');

        $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertStatus(200)
        ->assertViewIs('users.index');


        $user = User::factory()->create();
        $this->actingAs($user)
             ->get(route('users.index'))
             ->assertStatus(200)
             ->assertViewIs('users.show');
     }

     public function testCreateViewPreparation()
     {
        if (! Permission::where('name', 'manage-users')->exists()) {
            Permission::create(['name' => 'manage-users']);
        }
        // Create a user with required permissions to create another user.
        $user = User::factory()->create();
        $user->givePermissionTo('manage-users');

        //Act as the user
        $this->actingAs($user);

        //Try accessing the create view.
        $response = $this->get('/users/create'); // Adjust if the route is different.

        // Assert that the user can access the page.
        $response->assertStatus(200);

        // Optionally check for specific text.
        $response->assertSee('Create New User');
    }

    //Check if a user with the manage-user permission can access the eidt view of another user.
    public function testEditViewPreparation()
    {
        if (! Permission::where('name', 'manage-users')->exists()) {
            Permission::create(['name' => 'manage-users']);
        }

        // Create the 'Admin' role if it doesn't exist.
        if (! Role::where('name', 'Admin')->exists()) {
            Role::create(['name' => 'Admin']);
        }

            // Create a user with the 'manage-users' permission.
            $user = User::factory()->create();
            $user->givePermissionTo('manage-users');
            $user->assignRole('Admin');  // Assuming you have a method like this to assign roles.

            // Create another user that you want to edit.
            $userToEdit = User::factory()->create();

            // Act as the user with the 'manage-users' permission.
            $this->actingAs($user);

            // Try accessing the edit view for the other user.
            $response = $this->get("/users/{$userToEdit->id}/edit"); // Adjust if the route is different.

            // Assert that the user can access the page.
            $response->assertStatus(200);

            // Optionally check for specific text.
            $response->assertSee('Edit User');
    }

    public function testAccessLogicForCreateView()
    {
        // Create a user without the 'manage-users' permission.
        $user = User::factory()->create();

        // Act as the user.
        $this->actingAs($user);

        // Try accessing the create view.
        $response = $this->get('/users/create'); // Adjust if the route is different.

        // Assert that the user is denied access (typically 403 Forbidden).
        $response->assertStatus(403);
    }

    public function testAccessLogicForEditView()
    {
        // Create a user without the 'manage-users' permission.
        $user = User::factory()->create();

        // Create another user that you want to try editing.
        $userToEdit = User::factory()->create();

        // Act as the user without the 'manage-users' permission.
        $this->actingAs($user);

        // Try accessing the edit view for the other user.
        $response = $this->get("/users/{$userToEdit->id}/edit"); // Adjust if the route is different.

        // Assert that the user is denied access (typically 403 Forbidden).
        $response->assertStatus(302);
    }



}
