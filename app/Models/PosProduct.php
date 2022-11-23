<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosProduct extends Model
{
    protected $fillable = [
        'product_id',
        'pos_id',
        'quantity',
        'tax',
        'discount',
        'total',
    ];

    public function name(){
        return ProductService::find($this->product_id)->name;
    }

}
