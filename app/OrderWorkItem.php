<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderWorkItem extends Model {

    protected $fillable = ['order_id', 'file', 'fileUrl', 'externalFileUrl', 'message'];
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

    public function toArray() {
        $toArray = parent::toArray();
        $toArray['fileUrl'] = $this->fileUrl;
        return $toArray;
    }

    public function getFileurlAttribute($value) {
        return 'storage/'.$value;
    }
}
