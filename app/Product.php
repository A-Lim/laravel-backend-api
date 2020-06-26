<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Product;

use App\Http\Traits\CustomQuery;

class Product extends Model {
    use CustomQuery;

    protected $fillable = ['name', 'description', 'status', 'price', 'seqNo', 'delivery_days', 'highlighted', 'custom'];
    protected $hidden = [];
    protected $casts = [];

    public $timestamps = false;
    // list of properties queryable for datatable
    public static $queryable = ['name', 'description', 'status', 'price', 'seqNo', 'delivery_days', 'highlighted', 'custom'];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const CACHE_KEY = 'product';

    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
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
