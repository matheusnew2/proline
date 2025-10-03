<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAvailabilityRegister extends Model
{
    protected $table = 'stock_availability_register';
    protected $fillable = ['upload_id','battery_level','sku_name','answer','latitude','longitude','operation_name','created_at'];
}
