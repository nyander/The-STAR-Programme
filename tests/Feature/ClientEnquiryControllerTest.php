<?php

namespace Tests\Feature;

use App\Models\ClientEnquiry;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Spatie\Permission\Models\Role;

class ClientEnquiryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the permission if it doesn't exist
        if (! Permission::where('name', 'enquiry-access-to-all')->exists()) {
            Permission::create(['name' => 'enquiry-access-to-all']);
        }

        if (! Permission::where('name', 'client-enquiry-access')->exists()) {
            Permission::create(['name' => 'client-enquiry-access']);
        }
    }

    public function test_index_method_displays_all_enquiries_for_authorized_users()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('enquiry-access-to-all');
        $user->givePermissionTo('client-enquiry-access');

        $enquiries = ClientEnquiry::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/enquiries');

        $response->assertStatus(200);
        
        foreach($enquiries as $enquiry) {
            // Echo the subject for debugging
            echo "Testing for subject: {$enquiry->subject}\n";
            
            $response->assertSee($enquiry->subject);
        }
    }

    public function test_index_method_denies_access_for_users_without_permission()
    {
        // Create a user without giving any permissions
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/enquiries');

        // Expect a 403 Forbidden status
        $response->assertStatus(403);
    }

    public function test_create_method_denies_access_for_users_without_permission()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/enquiries/create'); // Adjust the URL as per your routes

        $response->assertStatus(403); // Expect a 403 Forbidden status
    }


    public function test_store_method_saves_new_enquiry_for_users_with_permission()
    {
        // Create the 'Admin' role if it doesn't exist.
        if (! Role::where('name', 'Admin')->exists()) {
            Role::create(['name' => 'Admin']);
        }

        $user = User::factory()->create();
        $user->givePermissionTo('enquiry-access-to-all');
        $user->givePermissionTo('client-enquiry-access');

        $enquiryData = [
            'subject' => 'Test Enquiry',
            'message' => 'This is a test content for the enquiry.', // changed from 'content' to 'message'
            'resolved' => false
        ];

        $response = $this->actingAs($user)->post('/enquiries', $enquiryData);

        $response->assertStatus(302); // Expect a redirect, usually after a successful POST request
        $this->assertDatabaseHas('client_enquiries', [
            'subject' => 'Test Enquiry',
            'content' => 'This is a test content for the enquiry.',  // note that in the database it might still be 'content'
            'resolved' => false
        ]); 
    }

    public function test_store_method_denies_access_for_users_without_permission()
    {
        $user = User::factory()->create();

        $enquiryData = [
            'subject' => 'Test Enquiry',
            'content' => 'This is a test content for the enquiry.',
            'resolved' => false
        ];

        $response = $this->actingAs($user)->post('/enquiries', $enquiryData);

        $response->assertStatus(403); // Expect a 403 Forbidden status
        $this->assertDatabaseMissing('client_enquiries', $enquiryData); // Assert that the given data does not exist in the database
    }


}
