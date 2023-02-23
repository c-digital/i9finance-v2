<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    protected $fillable = [
        'pos_id',
        'customer_id',
        'warehouse_id',
        'pos_date',
        'category_id',
        'status',
        'shipping_display',
        'created_by',
        'online',
        'order_status'
    ];

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }
    public function warehouse()
    {
        return $this->hasOne('App\Models\warehouse', 'id', 'warehouse_id');
    }

    public function posPayment(){
        return $this->hasOne('App\Models\PosPayment','pos_id','id');
    }

    public function getAmountAttribute()
    {
        $products = PosProduct::where('pos_id', $this->id)->get();

        $total = 0;

        foreach ($products as $product) {
            $total = $total + ($product->price * $product->quantity);
        }

        return number_format($total, 2);
    }
}



