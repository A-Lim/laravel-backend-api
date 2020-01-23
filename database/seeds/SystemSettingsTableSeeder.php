<?php
use Illuminate\Database\Seeder;

use App\SystemSetting;
use App\SystemSettingCategory;

use Carbon\Carbon;

class SystemSettingsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $now = Carbon::now();
        $generalCategory = SystemSettingCategory::create(['name' => 'General']);
        $authCategory = SystemSettingCategory::create(['name' => 'Authentication']);

        $systemsettings = [
            ['systemsettingcategory_id' => $generalCategory->id, 'name' => 'FrontEnd URL', 'code' => 'frontend_url', 'description' => '', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
        ];

        SystemSetting::insert($systemsettings);
    }
}
