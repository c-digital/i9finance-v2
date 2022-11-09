<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ecommerce extends Model
{
    protected $table = 'ecommerces';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['id_user', 'slug', 'name', 'logo', 'phone', 'address', 'title', 'description', 'type', 'type_company', 'nit', 'email', 'minimum_order', 'banner', 'facebook', 'instagram', 'google', 'youtube'];
}
