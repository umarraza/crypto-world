<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $adminPermissions = Permission::create(['name' => 'view backend']);
        $adminPermissions = Permission::create(['name' => 'payment management']);

        // Create Roles
        $admin = Role::create(['name' => config('access.users.super_admin')]);
        $customer = Role::create(['name' => config('access.users.customer_role')]);
   
        // assign permissions
        $admin->givePermissionTo(['view backend']);
        $customer->givePermissionTo(['payment management']);

        // assign roles
        $admin = User::find(1);
        $customer = User::find(2);

        if ($admin && $customer) {
            $admin->assignRole(config('access.users.super_admin'));
            $customer->assignRole(config('access.users.customer_role'));
        } else {
            return 'Something went wrong while assigning roles to users';
        }
    }
}