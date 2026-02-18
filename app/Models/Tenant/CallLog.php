<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    protected $fillable = [
        'agent_id',
        'call_sid',
        'phone_number',
        'duration',
        'cost',
        'status'
    ];
}
