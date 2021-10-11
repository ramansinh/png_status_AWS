<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class UserAction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','image_id','id','type'
    ];
    protected $table = 'user_action';

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function image(){
        return $this->belongsTo(Video::class,'image_id','id');
    }
    public function favourite(){
        //return $this->belongsTo(Favourite::class,'id','image_id');
        return $this->hasOne(Favourite::class,'image_id');
    }

}
