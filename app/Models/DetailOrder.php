<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'detail_order';
    protected $primaryKey = 'id_detail';
    public $timestamps = true;

    protected $fillable = [
        'id_order', 'id_ticket', 'total', 'value_voucher', 'value_down','quantity','id_event',
        'created_at','updated_at','seri_ticket',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }
   public function event(){
    return $this->belongsTo(Event::class, 'id_event','id_event');
   }

 
}