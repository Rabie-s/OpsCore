<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Admin::firstOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => 'Admin',
                'password' => env('ADMIN_PASSWORD'),
            ]
        );

        $role = Role::firstOrCreate([
            'name' => config('filament-shield.super_admin.name', 'super_admin'),
            'guard_name' => 'admin',
        ]);

        $role->syncPermissions(Permission::all());

        $user->assignRole($role);
    }
}
