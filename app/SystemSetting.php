<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model {

    protected $table = 'systemsettings';
    protected $fillable = [];
    protected $hidden = [];
    protected $casts = [];

    public const CACHE_KEY = 'systemsettings';

    public function systemSettingCategory() {
        return $this->belongsTo(SystemSettingCategory::class);
    }
}
