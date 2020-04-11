<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'company_id',
        'address',
        'index',
        'city',
        'street',
        'street_num',
        'building',
        'office',
        'litera'
    ];

    public function company(){
        return $this->hasOne(Company::class);
    }
}
