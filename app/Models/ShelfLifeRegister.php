<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShelfLifeRegister extends Model
{   
    protected $table = 'shelf_life_register';
    protected $fillable = ['upload_id','operation_name','sku_name','answer','latitude','longitude','battery_level','created_at','type','validity_at','amount','created_at'];
}
