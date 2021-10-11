<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sequence','language','name','image' ,'status',
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        return  !empty($this->attributes['image']) && Storage::exists($this->attributes['image'])? Storage::url($this->attributes['image']):null;
    }

    public function images(){
        return $this->hasMany('App\Model\Image','category_id');
    }

    public static $languages = [
        'Gujrati'=>'Gujrati',
        'Hindi'=>'Hindi',
        'English'=>'English',

    ];

    protected static function boot() {
        parent::boot();
        static::deleted(function($category) {
            $category->images()->delete();

        });
    }

}
