<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSurveyRegister extends Model
{
    protected $table = 'price_survey_register';
    protected $fillable = ['upload_id','operation_name','sku_name','price','competing','category','latitude','longitude','battery_level','created_at'];
}
