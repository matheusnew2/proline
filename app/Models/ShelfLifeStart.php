<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShelfLifeStart extends Model
{
    protected $table = 'shelf_life_start';
    protected $fillable = ['upload_id','battery_level','latitude','longitude','operation_name','created_at'];
}
