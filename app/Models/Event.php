<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    protected $table = 'events';
    protected $primaryKey = 'id_event';
    public $timestamps = true;

    protected $fillable = [
        'name_event', 'location', 'event_img', 'max_ticket', 'sold_ticket','delete_at',
        'date_start', 'date_end', 'description_event', 'latitude', 'longitude','delete_ever'
    ];
    
    public function ticket(){
        return $this->hasMany(Ticket::class,'id_event','id_event');
    }   
    public function detailOrder(){
      
    return $this->hasMany(DetailOrder::class,'id_event','id_event');
    }

}