<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTrackingEvents extends Model
{
    protected $table = 'time_tracking_events';
    protected $fillable = ['upload_id','type','latitude','longitude','battery_level','created_at'];
}
