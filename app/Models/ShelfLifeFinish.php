<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShelfLifeFinish extends Model
{
    protected $table = 'shelf_life_finish';
    protected $fillable = ['upload_id','battery_level','latitude','longitude','operation_name','created_at'];
}
