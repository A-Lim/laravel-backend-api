<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $table = 'order_items';
    protected $fillable = ['order_id', 'product_id', 'name', 'description', 'delivery_days', 'quantity', 'unit_price'];
    protected $hidden = [];
    protected $casts = [];

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
