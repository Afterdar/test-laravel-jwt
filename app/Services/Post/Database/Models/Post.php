<?php

namespace App\Services\Post\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];
}
