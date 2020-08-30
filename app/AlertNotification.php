<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertNotification extends Model
{
    protected $fillable = [
        'alert_log_id' , 'service_id' , 'wearer_id' , 'wearer_name' , 'alert_log_date', 'alert_log_time'
    ];
}
