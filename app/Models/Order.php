<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id','status','discount_id','total_amount','final_amount','paid_at'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function menus(): BelongsToMany {
        return $this->belongsToMany(Menu::class, 'order_items')
            ->withPivot(['quantity','unit_price','line_total'])
            ->withTimestamps();
    }

    public function paymentHistory(): HasOne {
        return $this->hasOne(PaymentHistory::class);
    }

    public function discount(): BelongsTo {
        return $this->belongsTo(Discount::class);
    }
}
