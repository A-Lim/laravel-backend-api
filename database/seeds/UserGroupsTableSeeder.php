<?php
use Illuminate\Database\Seeder;

use App\User;
use App\UserGroup;
use Carbon\Carbon;

class UserGroupsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now()->toDateTimeString();
        $userGroups = [
            ['code' => 'super_admin', 'name' => 'Super Admin', 'status' => 'active', 'isAdmin' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'normal', 'name' => 'Normal User', 'status' => 'active', 'isAdmin' => false, 'created_at' => $now, 'updated_at' => $now],
        ];

        UserGroup::insert($userGroups);

        $user = User::whereEmail('alexiuslim1994@gmail.com')->firstOrFail();
        $user->assignUserGroup('super_admin');
    }
}