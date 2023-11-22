<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve the permission IDs for role_id = 1
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
            'enquiry-view-all',
            'file-management-control',
            'category-management-access',
            'client-overview-access',
            'manage-users',
            'post-feedback-overview-list',
            'post-feedback-overview-viewable'
        ];

        $adminPermissionIds = Permission::whereIn('name', $adminPermissions)->pluck('id');


        $clientPermissions = [
            'client-goals-index',
            'client-goals-updateGoal',
            'performance-profile-list',
            'performance-profile-create',
            'client-overview-access',
            'client-enquiry-access',
            'post-feedback-overview-viewable'
        ];

        $clientPermissionIds = Permission::whereIn('name', $clientPermissions)->pluck('id');


       // Get the role models
        $adminRole = Role::where('name', 'Admin')->first();
        $clientRole = Role::where('name', 'Client')->first();

        // Sync the right permissions to each role
        $adminRole->syncPermissions($adminPermissionIds);

        $clientRole->syncPermissions($clientPermissionIds);
    }
}

