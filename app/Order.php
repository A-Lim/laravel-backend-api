<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\CustomQuery;

class Order extends Model {
    use CustomQuery;

    protected $fillable = ['email', 'currency', 'status', 'refNo', 'total', 'password', 'created_at', 'updated_at'];

    protected $hidden = [];
    protected $casts = [
        'created_at'  => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    // list of properties queryable for datatable
    public static $queryable = ['email', 'currency', 'status', 'refNo', 'total', 'password', 'created_at', 'updated_at'];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_COMPLETED = 'completed';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_PAID,
        self::STATUS_REFUNDED,
        self::STATUS_COMPLETED
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

    public function workitems() {
        return $this->hasMany(OrderWorkItem::class);
    }

    public function markAsPaid() {
        $this->update(['status' => self::STATUS_PAID]);
    }

    public function markAsCompleted() {
        $this->update(['status' => self::STATUS_PAID]);
    }
}
