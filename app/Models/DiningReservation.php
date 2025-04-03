<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiningReservation extends Model
{
    protected $table = 'dining_reservations';
    protected $primaryKey = 'id_reservation';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'restaurant_id',
        'reservation_date',
        'number_of_people',
        'special_requests',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
    ];

  
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_cart', 'id_cart');
    }


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id_restaurant');
    }
}