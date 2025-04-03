<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    protected $table = 'cate';
    protected $primaryKey = 'id_cate';
    public $timestamps = true;

    protected $fillable = [
        'name_cate', 'is_hidden',
        'created_at','updated_at',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_cate', 'id_cate');
    }
}