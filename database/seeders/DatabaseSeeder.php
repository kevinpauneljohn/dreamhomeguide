<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $superAdmin = Role::create(['name' => 'super admin']);
        $agent = Role::create(['name' => 'agent']);
        $team_leader = Role::create(['name' => 'team leader']);
        $manager = Role::create(['name' => 'manager']);

        User::create([
            'first_name' => 'John Kevin',
            'last_name' => 'Paunel',
            'phone' => '09171027662',
            'email' => 'johnkevinpaunel@gmail.com',
            'password' => bcrypt('123'),
        ])->assignRole($superAdmin);

        Permission::create(['name' => 'view listing']);
        Permission::create(['name' => 'add listing']);
        Permission::create(['name' => 'edit listing']);
        Permission::create(['name' => 'delete listing']);
        Permission::create(['name' => 'upload listing images']);

        Permission::create(['name' => 'view agent']);
        Permission::create(['name' => 'add agent']);
        Permission::create(['name' => 'edit agent']);
        Permission::create(['name' => 'delete agent']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view lead']);
        Permission::create(['name' => 'add lead']);
        Permission::create(['name' => 'edit lead']);
        Permission::create(['name' => 'delete lead']);
    }
}
