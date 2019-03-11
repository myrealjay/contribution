<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payday extends Model
{
    protected $fillable = [
        'scheme', 'payday', 'active',
    ];
}
