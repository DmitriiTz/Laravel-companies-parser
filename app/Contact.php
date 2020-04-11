<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'surname',
        'patronymic',
        'phone',
        'email',
        'division',
        'role',
        'indicate_in',
        'send'
    ];

    public function company(){
        return $this->hasOne(Company::class);
    }
}
