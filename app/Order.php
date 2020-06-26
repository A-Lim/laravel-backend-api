<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\CustomQuery;

class Order extends Model {
    use CustomQuery;

    protected $fillable = ['currency', 'status', 'refNo', 'total', 'password', 'created_at', 'updated_at'];

    protected $hidden = [];
    protected $casts = [];

    // list of properties queryable for datatable
    public static $queryable = ['currency', 'status', 'refNo', 'total', 'password', 'created_at', 'updated_at'];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_REFUNDED = 'refunded';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PAID,
        self::STATUS_REFUNDED
    ];

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();
    }

    public function transactions() {
        return $this->hasMany(OrderTransaction::class);
    }

    public function requirement() {
        return $this->hasOne(OrderRequirement::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function markAsPaid() {
        $this->update(['status' => self::STATUS_PAID]);
    }

    public function markAsCompleted() {
        $this->update(['status' => self::STATUS_PAID]);
    }
}
