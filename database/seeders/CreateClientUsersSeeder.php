<?php

namespace Database\Seeders;

use App\Models\ClientAgreement;
use App\Models\ClientOverview;
use App\Models\ContactDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateClientUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::pluck('id')->toArray();

        $role = Role::where('name', 'Client')->firstOrFail();

        // Create the first client user
        $user1 = User::create([
            'name' => 'LeBron James',
            'email' => 'lebron@lebron.com',
            'password' => bcrypt('password'),
            'assigned_performance_profile' => 1,
        ]);

        $user1->assignRole($role);
        
        $clientPermissions = [
            'client-goals-index',
            'client-goals-updateGoal',
            'performance-profile-list',
            'performance-profile-create',
            'client-overview-access',
            'post-feedback-overview-viewable'
        ];

        $clientPermissionIds = Permission::whereIn('name', $clientPermissions)->pluck('id');

        $lebronUser = User::where('name', 'LeBron James')->first();

        $lebronUser->syncPermissions($clientPermissionIds);

        // Create the associated client agreement for user1
        ClientAgreement::create([
            'user_id' => $user1->id,
            'preferred_days' => 'Monday',
            'preferred_times' => 'Morning',
            'program_duration' => 3,
            'consent' => true,
            'confidentiality' => true,
        ]);

        // Create the client overview for user1
        ClientOverview::create([
            'user_id' => $user1->id,
            'performanceProfile_id' => 1,
            'current_sport' => 'Basketball',
            'experience_level' => 'Professional',
        ]);

        ContactDetail::create([
            'user_id' => $user1->id,
            'phone_number' => '01234567890',
            'city' => 'Colchester',
            'state' => 'Essex',
            'postal_code' => 'Co1 234',
            'country' => 'United Kingdom',
            'emergency_contact_name' => 'Jermaine',
            'emergency_contact_phone' => '09876543210',
        ]);

        // Create the second client user
        $user2 = User::create([
            'name' => 'Richard Nyande',
            'email' => 'richard@richard.com',
            'password' => bcrypt('password'),
            'assigned_performance_profile' => 1,
        ]);

        $user2->assignRole($role);
        $user2->syncPermissions($clientPermissionIds);

        // Create the associated client agreement for user2
        ClientAgreement::create([
            'user_id' => $user2->id,
            'preferred_days' => 'Tuesday',
            'preferred_times' => 'Afternoon',
            'program_duration' => 6,
            'consent' => true,
            'confidentiality' => true,
        ]);

        // Create the client overview for user2
        ClientOverview::create([
            'user_id' => $user2->id,
            'performanceProfile_id' => 1,
            'current_sport' => 'Football',
            'experience_level' => 'Amateur',
        ]);

        ContactDetail::create([
            'user_id' => $user2->id,
            'phone_number' => '01234567890',
            'city' => 'Colchester',
            'state' => 'Essex',
            'postal_code' => 'Co1 234',
            'country' => 'United Kingdom',
            'emergency_contact_name' => 'Jermaine',
            'emergency_contact_phone' => '09876543210',
        ]);
    }
}
