<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

<<<<<<< HEAD
    $permissions = [
        'view-beneficiary',
        'edit-beneficiary',
        'delete-beneficiary'
=======
$permissions = [
    'view-user',
        'view-user-details',
        'edit-user',
        'update-user',
        'delete-user',


>>>>>>> c855ef29d241d760f28a890b0ca30045e1ae5b12
    ];

    foreach ($permissions as $permission) {
        Permission::create(['name' => $permission]);
        }

    }
}
