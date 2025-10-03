<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAvailabilityFinish extends Model
{
    protected $table = 'stock_availability_finish';
    protected $fillable = ['upload_id','battery_level','latitude','longitude','operation_name','created_at'];
}
