<?php
use Illuminate\Database\Seeder;

use App\Permission;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now()->toDateTimeString();
        $permissions = [
            // users
            ['code' => 'users.view', 'name' => 'View User', 'description' => '', 'module' => 'User', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'users.viewAny', 'name' => 'View Any Users', 'description' => '', 'module' => 'User', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'users.create', 'name' => 'Create Users', 'description' => '', 'module' => 'User', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'users.update', 'name' => 'Update Users', 'description' => '', 'module' => 'User', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'users.delete', 'name' => 'Delete Users', 'description' => '', 'module' => 'User', 'created_at' => $now, 'updated_at' => $now],
            // usergroups
            ['code' => 'usergroups.view', 'name' => 'View User Group', 'description' => '', 'module' => 'User Groups', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'usergroups.viewAny', 'name' => 'View Any User Groups', 'description' => '', 'module' => 'User Groups', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'usergroups.create', 'name' => 'Create User Groups', 'description' => '', 'module' => 'User Groups', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'usergroups.update', 'name' => 'Update User Groups', 'description' => '', 'module' => 'User Groups', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'usergroups.delete', 'name' => 'Delete User Groups', 'description' => '', 'module' => 'User Groups', 'created_at' => $now, 'updated_at' => $now],
        ];
        Permission::insert($permissions);
    }
}
