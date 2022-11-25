<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
	protected $casts = ['options' => 'array'];
	public $timestamps = false;
}
