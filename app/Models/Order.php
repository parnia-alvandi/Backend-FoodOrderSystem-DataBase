<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','menu_id','quantity','unit_price',
        'discount_code','discount_amount','total_amount','status'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function menu() { return $this->belongsTo(Menu::class); }
}
