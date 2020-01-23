<?php
namespace App\Repositories\SystemSetting;

use App\SystemSetting;

interface SystemSettingRepositoryInterface {
     /**
     * List all systemsettings grouped by systemsettingcategory
     * 
     * @return [SystemSettingCategory]
     */
    public function list();

     /**
     * Update multple systemsettings at once
     * 
     * @param array ['code' => 'value']
     * @return void
     */
    public function update($data);
}