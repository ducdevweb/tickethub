<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $table = 'ticket';
    protected $primaryKey = 'id_ticket';
    public $timestamps = true;

    protected $fillable = [
     'id_cate','id_event', 'name_ticket', 'price_ticket', 'sale_ticket',   'delete_at',
        'quantity_ticket', 'description_ticket', 'img_ticket', 'hidden_ticket','type_ticket','bought','delete_ever',
        'created_at','updated_at',
    ];

    public function cate()
    {
        return $this->belongsTo(Cate::class, 'id_cate', 'id_cate');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_ticket', 'id_ticket');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_ticket', 'id_ticket');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_ticket', 'id_ticket');
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'id_ticket', 'id_ticket');
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
}