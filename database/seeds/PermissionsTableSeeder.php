<?php
use Illuminate\Database\Seeder;

use App\Permission;
use App\PermissionModule;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now()->toDateTimeString();
        $permission_modules = [
            ['code' => 'users', 'name' => 'Users', 'description' => 'User module', 'is_active' => '1'],
            ['code' => 'usergroups', 'name' => 'User Groups', 'description' => 'User Groups module', 'is_active' => '1'],
            ['code' => 'systemsettings', 'name' => 'System Settings', 'description' => 'System Settings module', 'is_active' => '1'],
            ['code' => 'announcements', 'name' => 'Announcements', 'description' => 'Announcements module', 'is_active' => '1'],
            ['code' => 'products', 'name' => 'Products', 'description' => 'Products module', 'is_active' => '1'],
            ['code' => 'orders', 'name' => 'Orders', 'description' => 'Orders module', 'is_active' => '1']
        ];

        $permissions = [
            // users
            ['permission_module_id' => '1', 'code' => 'users.view', 'name' => 'View User', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.viewAny', 'name' => 'View Any Users', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.create', 'name' => 'Create Users', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.update', 'name' => 'Update Users', 'description' => ''],
            ['permission_module_id' => '1', 'code' => 'users.delete', 'name' => 'Delete Users', 'description' => ''],
            // usergroups
            ['permission_module_id' => '2', 'code' => 'usergroups.view', 'name' => 'View User Group', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.viewAny', 'name' => 'View Any User Groups', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.create', 'name' => 'Create User Groups', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.update', 'name' => 'Update User Groups', 'description' => ''],
            ['permission_module_id' => '2', 'code' => 'usergroups.delete', 'name' => 'Delete User Groups', 'description' => ''],
            // systemsettings
            ['permission_module_id' => '3', 'code' => 'systemsettings.viewAny', 'name' => 'View Any System Settings', 'description' => ''],
            ['permission_module_id' => '3', 'code' => 'systemsettings.update', 'name' => 'Update System Settings', 'description' => ''],
            // announcements
            ['permission_module_id' => '4', 'code' => 'announcements.view', 'name' => 'View Announcements', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'announcements.viewAny', 'name' => 'View Any Announcements', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'announcements.create', 'name' => 'Create Announcements', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'announcements.update', 'name' => 'Update Announcements', 'description' => ''],
            ['permission_module_id' => '4', 'code' => 'announcements.delete', 'name' => 'Delete Announcements', 'description' => ''],
            // products
            ['permission_module_id' => '5', 'code' => 'products.view', 'name' => 'View Products', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'products.viewAny', 'name' => 'View Any Products', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'products.create', 'name' => 'Create Products', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'products.update', 'name' => 'Update Products', 'description' => ''],
            ['permission_module_id' => '5', 'code' => 'products.delete', 'name' => 'Delete Products', 'description' => ''],
            // orders
            ['permission_module_id' => '6', 'code' => 'orders.view', 'name' => 'View Orders', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'orders.viewAny', 'name' => 'View Any Orders', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'orders.create', 'name' => 'Create Orders', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'orders.update', 'name' => 'Update Orders', 'description' => ''],
            ['permission_module_id' => '6', 'code' => 'orders.delete', 'name' => 'Delete Orders', 'description' => ''],
        ];

        PermissionModule::insert($permission_modules);
        Permission::insert($permissions);
    }
}
