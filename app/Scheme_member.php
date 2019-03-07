<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scheme_member extends Model
{
    protected $fillable = [
        'scheme', 'name', 'email', 'phone', 'amount', 'payday',
    ];
}
