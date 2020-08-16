<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatcherRelation extends Model
{

    protected $fillable = [
        'svc_id' , 'watcher_id' , 'priority_num' , 'watcher_status', 'watcher_device_token'
    ];

}
