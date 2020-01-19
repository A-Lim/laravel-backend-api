<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends Model {
    use SoftDeletes;

    protected $table = 'usergroups';
    protected $fillable = ['name', 'code', 'status', 'isAdmin', 'deleted_at'];
    protected $hidden = ['deleted_at', 'pivot'];
    protected $casts = ['isAdmin' => 'boolean'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE
    ];

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        self::creating(function($model) {
            // if status is not provided
            // set default to unverified
            if (empty($model->status)) {
                $model->status = self::STATUS_ACTIVE;
            }
        });
    }

    public function users() {
        return $this->belongsToMany(User::class, 'user_usergroup', 'user_id', 'usergroup_id'); 
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permission_usergroup', 'usergroup_id', 'permission_id'); 
    }

    public function givePermissions(array $ids) {
        $this->permissions()->sync($ids);
    }
}
