<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'active_ads','admob_app_id','admob_banner_id','admob_fullscreen_id','admob_nativex_id','facebook_banner_id','facebook_fullscreen_id'
    ];
    protected $table = 'settings';

//    public function user(){
//        return $this->belongsTo(User::class,'user_id','id');
//    }

public static $active_ads = [
    'facebook_ad'=>'facebook_ad',
    'admob_ad'=>'admob_ad',

];

}
