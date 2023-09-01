<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Rifat Hussein', 
            'email' => 'admin@me.com',
            'password' => bcrypt('password')
        ]);

        $role = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Client']);


        $adminPermissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'performance-profile-template-list',
            'performance-profile-template-create',
            'performance-profile-template-edit',
            'performance-profile-template-delete',
            'enroll-client',
            'client-goals-index',
            'client-goals-create',
            'client-goals-edit',
            'client-goals-delete',
            'client-goals-updateGoal',
            'performance-profile-list',
            'performance-profile-create',
            'performance-profile-edit',
            'performance-profile-delete',
            'client-enquiry-access',
            'enquiry-access-to-all',
            'enquiry-view-all', //user  can view all enquiries
            'file-management-control',
            'category-management-access',
            'client-overview-access',
            'manage-users',
            'post-feedback-overview-list',
            'post-feedback-overview-viewable'
        ];

        $adminPermissionIds = Permission::whereIn('name', $adminPermissions)->pluck('id');

        $adminRole = Role::where('name', 'Admin')->first();

        $adminRole->syncPermissions($adminPermissionIds);


        $user->assignRole($role);
    }
}
