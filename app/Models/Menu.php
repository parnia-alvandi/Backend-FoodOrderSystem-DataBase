<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name','description','price'];

    public function comments(){
        return $this->hasMany(Comment::class, 'menu_id');
    }

    public function surveys() {
        return $this->hasMany(Survey::class);
    }
}
