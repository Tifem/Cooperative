<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
=======
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

>>>>>>> c855ef29d241d760f28a890b0ca30045e1ae5b12

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Adebayo Nathaniel',
            'email' => 'adebayonath@gmail.com',
<<<<<<< HEAD
            'password' => bcrypt('Olalink6204##'),
            ]);
        $role = Role::create(['name' => 'Admin', 'id' => 1]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
=======
            'password' => bcrypt('Olalink6204##')
            ]);
            $role = Role::create(['name' => 'Admin','id'=>1]);
            $permissions = Permission::pluck('id','id')->all();
            $role->syncPermissions($permissions);
            $user->assignRole([$role->id]);
            }

>>>>>>> c855ef29d241d760f28a890b0ca30045e1ae5b12
}
