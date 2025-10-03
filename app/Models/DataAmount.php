<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAmount extends Model
{
    protected $table = 'data_amount';
    protected $fillable = ['upload_id','table','qtd'];
}
