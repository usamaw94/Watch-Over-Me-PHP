<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'battery_percentage' , 'location_latitude' , 'location_longitude' , 'log_text' , 'log_date', 'log_time','log_type','service_id','request_status'
    ];
}
