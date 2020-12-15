<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function phim()
    {
        return $this->belongsTo('App\Models\Phim','phim_id','id');
    }
}