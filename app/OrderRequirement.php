<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRequirement extends Model {

    protected $fillable = ['order_id', 'submitted', 'name', 'email', 'description', 'file', 'fileUrl', 'fromLang', 'toLang', 'deliveryStatus'];
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

    public function toArray() {
        $toArray = parent::toArray();
        $toArray['fileUrl'] = $this->fileUrl;
        return $toArray;
    }

    public function getFileurlAttribute($value) {
        return 'storage/'.$value;
    }
}