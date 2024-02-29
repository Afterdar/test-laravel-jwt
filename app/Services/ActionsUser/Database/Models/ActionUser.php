<?php

declare(strict_types=1);

namespace App\Services\ActionsUser\Database\Models;

use Illuminate\Database\Eloquent\Model;

class ActionUser extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'action',
        'user_id',
    ];
}
