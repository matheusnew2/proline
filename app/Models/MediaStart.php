<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaStart extends Model
{
    protected $table = 'media_start';
    protected $fillable = ['upload_id','battery_level','latitude','longitude','operation_name','created_at'];
}
