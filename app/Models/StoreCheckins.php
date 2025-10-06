<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCheckins extends Model
{
    protected $fillable = ['upload_id','battery_level','latitude','longitude','store_name','created_at'];
}
