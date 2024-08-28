<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    // protected $fillable = ['name', 'status'];

    public function orderLine()
    {
        return $this->hasMany('App\Models\OrderLine', 'orders');
    }

    public function subTotal()
    {
        $orders     = $this->id;
        $subtotal   = \App\Models\OrderLine::where('orders', $orders)
            ->sum('subtotal');

        return $subtotal;
    }

    public function totalQty()
    {
        $orders     = $this->id;

        $qty        = \App\Models\OrderLine::where('orders', $orders)
            ->sum('qty');

        return $qty;
    }


}
