<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'scheme_member_id', 'scheme', 'amount','week',
    ];
}
