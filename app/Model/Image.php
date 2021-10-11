<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'category_id','language','preview_image','frame_image' ,'status','total_view','total_share','total_download','total_edit'
    ];
    protected $appends = ['preview_image_url','frame_image_url'];
    protected $table = 'image';

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function favourite(){
        //return $this->belongsTo(Favourite::class,'id','image_id');
        return $this->hasOne(Favourite::class,'image_id');
    }

    public function useraction(){
        //return $this->belongsTo(Favourite::class,'id','image_id');
        return $this->hasMany(UserAction::class,'image_id');
    }
    public function view(){
        return $this->hasMany(UserAction::class,'image_id')->where('type','view');
    }
    public function download(){
        return $this->hasMany(UserAction::class,'image_id')->where('type','download');
    }
    public function share(){
        return $this->hasMany(UserAction::class,'image_id')->where('type','share');
    }
    public function edit(){
        return $this->hasMany(UserAction::class,'image_id')->where('type','edit');
    }


    public function getPreviewImageUrlAttribute($value)
    {
        return  !empty($this->attributes['preview_image']) && Storage::exists($this->attributes['preview_image'])? Storage::url($this->attributes['preview_image']):null;
    }
    public function getFrameImageUrlAttribute($value)
    {
        return  !empty($this->attributes['frame_image']) && Storage::exists($this->attributes['frame_image'])? Storage::url($this->attributes['frame_image']):null;
    }

}
