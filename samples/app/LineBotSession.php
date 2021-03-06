<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineBotSession extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'room_id',
        'session_type',
        'last_activity',
    ];
}
