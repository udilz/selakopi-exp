<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    protected $guarded = [];

    public function orderLine()
    {
        return $this->hasMany('App\Models\OrderLine');
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
