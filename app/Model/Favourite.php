<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Favourite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','image_id','id'
    ];
    protected $table = 'favourite';

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function image(){
        return $this->belongsTo(Video::class,'image_id','id');
    }

}
