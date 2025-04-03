<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';
    protected $primaryKey = 'id_voucher';
    public $timestamps = true;

    protected $fillable = [
        'value', 'limit', 'date_from', 'date_to',
        'created_at','updated_at',
    ];
}