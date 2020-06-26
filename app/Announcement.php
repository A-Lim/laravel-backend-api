<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Http\Traits\CustomQuery;

class Announcement extends Model {
    use SoftDeletes, CustomQuery;

    protected $fillable = ['title', 'content', 'status', 'send_notification', 'schedule_at', 'deleted_at', 'created_by', 'updated_by'];
    protected $hidden = ['deleted_at', 'pivot'];
    protected $casts = [];

    // list of properties queryable for datatable
    public static $queryable = ['title', 'content', 'status', 'send_notification', 'schedule_at', 'deleted_at', 'created_by', 'updated_by'];

    public const TYPE_EMAIL = 'email';
    public const TYPE_WEB = 'web';
    public const TYPE_PHONE = 'phone';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';

    public const ACTION_SAVE = 'save';
    public const ACTION_PUBLISH = 'publish';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_ACTIVE
    ];

    public const ACTIONS = [
        self::ACTION_SAVE,
        self::ACTION_PUBLISH,
    ];

    public const TYPES = [
        self::TYPE_EMAIL,
        self::TYPE_WEB,
        self::TYPE_PHONE,
    ];

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();
    }
}
