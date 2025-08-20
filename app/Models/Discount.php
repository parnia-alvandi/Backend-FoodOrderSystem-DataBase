<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code','type','value','min_order_amount','usage_limit','times_used','expires_at','active'
    ];
}
