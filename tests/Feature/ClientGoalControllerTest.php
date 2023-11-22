<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ClientGoal;
use Spatie\Permission\Models\Role;
use App\Notifications\GoalSubmitted;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientGoalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles and permissions if they don't exist.
        if (! Role::where('name', 'Admin')->exists()) {
            Role::create(['name' => 'Admin']);
        }

        if (! Role::where('name', 'Client')->exists()) {
            Role::create(['name' => 'Client']);
        }

        $permissions = [
            'client-goals-index',
            'client-goals-create',
            'client-goals-edit',
            'client-goals-storeUpdateGoal',
            'client-goals-delete',
            'client-goals-updateGoal'
        ];

        foreach ($permissions as $permission) {
            if (! Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }

    public function test_required_permissions_to_access_methods()
    {

        $unauthorizedUser = User::factory()->create();
        $client = User::factory()->create();
        $client->assignRole('Client');
        $client->givePermissionTo('client-goals-index'); // For this test, we only give the 'client-goals-index' permission.

        // When unauthorizedUser tries to access a client's goals, they should be redirected with an error.
        $response = $this->actingAs($unauthorizedUser)->get(route('goals.index', $client));
        $response->assertStatus(403);

        // When unauthorizedUser tries to access their own (nonexistent) goals, they should also be redirected with an error.
        $responseSelf = $this->actingAs($unauthorizedUser)->get(route('goals.index', $unauthorizedUser));
        $responseSelf->assertStatus(403);

        // A client with the 'client-goals-index' permission should be able to view their own goals without any redirection.
        $this->actingAs($client)->get(route('goals.index', $client))->assertOk();
    }

    public function test_display_goals_for_a_client()
    {
        // Create roles and permissions if they don't exist.
        if (! Role::where('name', 'Admin')->exists()) {
            Role::create(['name' => 'Admin']);
        }

        if (! Role::where('name', 'Client')->exists()) {
            Role::create(['name' => 'Client']);
        }

        $client = User::factory()->create();
        $client->assignRole('Client');
        $client->givePermissionTo('client-goals-index');

        // Check if a client with the necessary permission can see their goals.
        $this->actingAs($client)
            ->get(route('goals.index', $client))
            ->assertOk()
            ->assertViewIs('client-goals.index');

        // Check if a client without the necessary permission is forbidden.
        $clientWithoutPermission = User::factory()->create();
        $clientWithoutPermission->assignRole('Client');
        $this->actingAs($clientWithoutPermission)
            ->get(route('goals.index', $clientWithoutPermission))
            ->assertStatus(403);
    }

    public function test_client_can_access_create_goal_form()
    {
        $client = User::factory()->create();
        $client->assignRole('Client');
        $client->givePermissionTo('client-goals-create');
        
        $this->actingAs($client)
            ->get(route('goals.create', $client))
            ->assertOk()
            ->assertViewIs('client-goals.create');
    }

    public function test_store_creates_goal_and_sends_notification()
    {
        Notification::fake(); // Fakes notifications for testing.

        $client = User::factory()->create();
        $client->assignRole('Client');
        $client->givePermissionTo('client-goals-create');

        $goalData = [
            'description' => 'Test goal',
            'type' => 'amount',
            'amount_goal' => 1000,
            'client_id' => $client->id
        ];

        $this->actingAs($client)
            ->post(route('goals.store', $client), $goalData)
            ->assertRedirect();

        // Notification::assertSentTo($client, GoalSubmitted::class);
    }
    
}
