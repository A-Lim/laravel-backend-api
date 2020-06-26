<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\CustomQuery;

class Contact extends Model {
    use CustomQuery;

    protected $fillable = ['name', 'email', 'message', 'read'];
    protected $hidden = [];
    protected $casts = [];

    // list of properties queryable for datatable
    public static $queryable = ['name', 'email', 'message', 'read', 'created_at'];

    /**
     * Model events
     *
     * @return void
     */
    public static function boot() {
        parent::boot();
    }

    public function markAsRead($status = true) {
        $this->update(['read' => $status]);
    }
}
