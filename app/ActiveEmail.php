<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveEmail extends Model
{
    protected $fillable = [
        'type',
        'email',
        'sended'
    ];
}
