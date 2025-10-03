<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSurveyFinish extends Model
{
    protected $table = 'price_survey_finish';
    protected $fillable = ['upload_id','battery_level','latitude','longitude','operation_name','created_at'];
}
