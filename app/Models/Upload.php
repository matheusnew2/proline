<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'upload';
    protected $fillable = ['file_path'];

    public function getHasMany($model)
    {
        return $this->hasMany("App\\Models\\{$model}",'upload_id');
    }
    public function getAmountFile()
    {
        return $this->hasMany(DataAmount::class,'upload_id');
    }
}
