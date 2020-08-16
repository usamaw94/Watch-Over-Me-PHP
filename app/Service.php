<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_id' , 'wearer_id' , 'customer_id' , 'wom_num' , 'service_status', 'no_of_watchers','wearer_device_token','customer_device_token','wearer_logged_in'
    ];
}
