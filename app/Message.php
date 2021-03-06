<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'message', 'user_id', 'recepient_id', 'read'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
