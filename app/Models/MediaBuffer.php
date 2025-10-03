<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaBuffer extends Model
{
    protected $table = 'media_buffer';
    protected $fillable = ['upload_id','image','battery_level','latitude','longitude','operation_name','status','created_at'];
}
