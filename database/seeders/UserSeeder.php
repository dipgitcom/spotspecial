<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $roles = ['Civilian', 'Trucker', 'Owner', 'Super Admin'];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role],
                ['guard_name' => 'web']
            );
        }





        $owner_user = User::firstOrCreate(
            ['id' => 1], 
            [
                'name' => 'Owner',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );
        $owner_user->assignRole('Owner');
       $super_admin = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'SuperAdmin',
                'password' => Hash::make('12345678'),
            ]
        );
        $super_admin->assignRole('Super Admin');


        $permissions = [
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }


        $allPermissions = Permission::pluck('name')->toArray();

        Role::where('name', 'Super Admin')->first()?->syncPermissions($allPermissions);
        Role::where('name', 'Owner')->first()?->syncPermissions($allPermissions);
    }
}
