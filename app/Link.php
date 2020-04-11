<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Link extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'link'
    ];
}
