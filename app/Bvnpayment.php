<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bvnpayment extends Model
{
   
    protected $fillable = [
        'user_id', 'amount',
    ];
}
