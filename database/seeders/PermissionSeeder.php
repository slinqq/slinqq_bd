<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Create roles
        $superAdminRole = Role::create(['name' => 'superadmin', 'guard_name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager', 'guard_name' => 'web']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);

        //Create permissions
        $manageSuperAdmin = Permission::create(['name' => 'manage-company', 'guard_name' => 'superadmin']);
        $manageAdmin = Permission::create(['name' => 'manage-company', 'guard_name' => 'admin']);
        $managemanager = Permission::create(['name' => 'manage-company', 'guard_name' => 'web']);

         $createSuperadmin = Permission::create(['name' => 'create company', 'guard_name' => 'superadmin']);
        $editCompanySuperadmin = Permission::create(['name' => 'edit company', 'guard_name' => 'superadmin']);

        // Assign permissions to roles

        $superAdminRole->givePermissionTo([$manageSuperAdmin]);
        $adminRole->givePermissionTo([$manageAdmin]);
        $managerRole->givePermissionTo([$managemanager]);

        // Create a user and assign roles

        $suprAdminUser = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('password'),
            'phone' => '123456789',
            'address' => 'Raozan, Chattogram',
            'city' => 'Raozan, Chattogram',
            'country' => 'Bangladesh',
            'email_verified_at' => now(),
            'status' => 'active',
        ]);
        $suprAdminUser->assignRole($superAdminRole);

        // $adminUser = \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@admin.com',
        //     'password' => bcrypt('password'),
        //     'phone' => '123456789',
        //     'address' => 'Boshundhora, Dhaka',
        //     'city' => 'Dhaka',
        //     'country' => 'Bangladesh',
        //     'email_verified_at' => now(),
        //     'status' => 'active',
        // ]);

        // $adminUser->assignRole($adminRole);

        // $managerUser = \App\Models\User::factory()->create([
        //     'name' => 'Manager',
        //     'email' => 'manager@manager.com',
        //     'password' => bcrypt('password'),
        //     'phone' => '123456789',
        //     'address' => 'Boshundhora, Dhaka',
        //     'city' => 'Dhaka',
        //     'country' => 'Bangladesh',
        //     'email_verified_at' => now(),
        //     'status' => 'active',
        // ]);

        // $managerUser->assignRole($userRole);

        // $normalUser = \App\Models\User::factory()->create([
        //     'name' => 'User',
        //     'email' => 'user@user.com',
        //     'password' => bcrypt('password'),
        //     'phone' => '123456789',
        //     'address' => 'Boshundhora, Dhaka',
        //     'city' => 'Dhaka',
        //     'country' => 'Bangladesh',
        // ]);

        // $normalUser->assignRole($userRole);

        // // create 10 users with factory and assign roles

        // \App\Models\User::factory(10)->create()->each(function ($user) use ($userRole) {
        //     $user->assignRole($userRole);
        // });

        // // create 10 admin users with factory and assign roles

        // \App\Models\User::factory(10)->create()->each(function ($user) use ($adminRole) {
        //     $user->assignRole($adminRole);
        // });
    }
}
