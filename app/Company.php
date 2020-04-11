<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'id',
        'create_date',
        'manager',
        'name',
        'company_id',
        'mark',
        'status',
        'change_status',
        'email',
        'email_bill',
        'phone',
        'address',
        'description',
        'pay_type',
        'client_type',
        'company',
        'sender',
        'agent_buisnes',
    ];
}
