<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAvailabilityStart extends Model
{
    protected $table = 'stock_availability_start';
    protected $fillable = ['upload_id','battery_level','latitude','longitude','operation_name','created_at'];
}
