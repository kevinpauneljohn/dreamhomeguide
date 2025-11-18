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

        User::factory()->create([
            'name' => 'John Kevin Paunel',
            'email' => 'johnkevinpaunel@gmail.com',
            'password' => bcrypt('123'),
        ])->assignRole($superAdmin);

        Permission::create(['name' => 'view listing']);
        Permission::create(['name' => 'add listing']);
        Permission::create(['name' => 'edit listing']);
        Permission::create(['name' => 'delete listing']);

        Permission::create(['name' => 'view agent']);
        Permission::create(['name' => 'add agent']);
        Permission::create(['name' => 'edit agent']);
        Permission::create(['name' => 'delete agent']);
    }
}
