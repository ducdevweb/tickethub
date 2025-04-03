<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id_cart';
    public $timestamps = true;

    protected $fillable = [
        'id_user', 'id_ticket', 'id_seat', 'quantity_cart', 'total_cart',
        'created_at','updated_at',
    ];
    protected $casts = [
        'seat_ids' => 'array', 
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function event()
    {
        return $this->hasOneThrough(Event::class, Ticket::class, 'id_ticket', 'id_event', 'id_ticket', 'id_event');
    }
    
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

 
}