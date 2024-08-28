<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;
    protected $table    = 'order_line';
    public $timestamps  = false;

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'orders');
    }

    public function table()
    {
        return $this->belongsTo('App\Models\Table', 'tables');
    }

    public function food()
    {
        return $this->belongsTo('App\Models\Food', 'foods');
    }

    public function totalQty()
    {
        return $this->sum('qty');
    }


    public function grandTotal()
    {
        return $this->sum('subtotal');
    }

}
