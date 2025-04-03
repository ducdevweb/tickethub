<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurants';
    protected $primaryKey = 'id_restaurant';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'description',
    ];

    public function reservations()
    {
        return $this->hasMany(DiningReservation::class, 'restaurant_id', 'id_restaurant');
    }
}