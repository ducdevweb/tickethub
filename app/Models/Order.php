<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id_order';
    public $timestamps = true;

    protected $fillable = [
        'id_user','name','phone', 'email', 'address','status',
        'created_at','updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_order', 'id_order');
    }
}