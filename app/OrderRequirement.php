<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRequirement extends Model {

    protected $fillable = ['order_id', 'name', 'email', 'description', 'file', 'fromLang', 'toLang', 'deliveryStatus'];
    protected $hidden = [];
    protected $casts = [];

    public $timestamps = false;

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
