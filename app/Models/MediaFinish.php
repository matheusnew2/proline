<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaFinish extends Model
{
    protected $table = 'media_finish';
    protected $fillable = ['upload_id','battery_level','latitude','longitude','operation_name','created_at'];
}
