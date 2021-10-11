<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Privacy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sequence','privacy',
    ];

    protected $table = 'privacy';

}
