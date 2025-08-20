<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    protected $fillable = ['user_id','menu_id','rating','comment'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function menu(): BelongsTo {
        return $this->belongsTo(Menu::class);
    }
}
