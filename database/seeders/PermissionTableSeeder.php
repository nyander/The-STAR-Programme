<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
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
            'enquiry-view-all',
            'enquiry-access-to-all',
            'file-management-control',
            'category-management-access',
            'client-overview-access',
            'manage-users',
            'post-feedback-overview-list',
            'post-feedback-overview-viewable'
         ];
         
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
