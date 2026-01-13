<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
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
//        // 1. Create roles
//        $superAdmin = Role::create(['name' => 'super admin']);
//        $agent      = Role::create(['name' => 'agent']);
//        $teamLeader = Role::create(['name' => 'team leader']);
//        $manager    = Role::create(['name' => 'manager']);
//
//        // 2. Create user
//        User::create([
//            'first_name' => 'John Kevin',
//            'last_name'  => 'Paunel',
//            'phone'      => '09171027662',
//            'email'      => 'johnkevinpaunel@gmail.com',
//            'password'   => bcrypt('123'),
//            'position'   => 'Head Marketer'
//        ])->assignRole($superAdmin);
//
//        // 3. Create ALL permissions first
//        $permissions = [
//            // listings
//            'view listing','add listing','edit listing','delete listing','upload listing images',
//
//            // agents
//            'view agent','add agent','edit agent','delete agent',
//
//            // users
//            'view user','add user','edit user','delete user',
//
//            // leads
//            'view lead','add lead','edit lead','delete lead',
//
//            // notes
//            'view note','add note','edit note','delete note',
//
//            // blogs
//            'view blog','add blog','edit blog','delete blog',
//
//            // appointments
//            'view appointment','add appointment','edit appointment','delete appointment',
//
//            // roles
//            'view role','add role','edit role','delete role',
//
//            // permissions
//            'view permission','add permission','edit permission','delete permission',
//
//            // task
//            'view task','add task','edit task','delete task',
//
//            // projecta
//            'view project','add project','edit project','delete project',
//        ];
//
//        foreach ($permissions as $permission) {
//            Permission::firstOrCreate(['name' => $permission]);
//        }
//
//        // 4. Assign permissions AFTER creation
//        $manager->syncPermissions($permissions);
//
//        // Optional: Super Admin gets everything
//        $superAdmin->syncPermissions($permissions);

//        Task::factory()->count(5)->create();

        Project::factory()->count(5)->create();
    }
}
