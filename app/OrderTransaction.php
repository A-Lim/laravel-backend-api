<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\CustomQuery;

class OrderTransaction extends Model {
    use CustomQuery;

    protected $fillable = ['order_id', 'action', 'payment_transaction_id', 'status', 'payment_platform', 'details', 'created_at', 'updated_at'];
    protected $hidden = [];
    protected $casts = [];

    // list of properties queryable for datatable
    public static $queryable = ['order_id', 'action', 'payment_transaction_id', 'status', 'payment_platform', 'details', 'created_at', 'updated_at'];

    public const ACTION_PAY = 'pay';
    public const ACTION_REFUND = 'refund';

    public const PLATFORM_STRIPE = 'stripe';
    public const PLATFORM_PAYPAL = 'paypal';

    public const STATUS_FAIL = 'fail';
    public const STATUS_SUCCESS = 'success';

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
