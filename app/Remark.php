<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $table = 'remarks';

    protected $fillable = [
        'content', 'user_id', 'request_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function request()
    {
        return $this->belongsTo('App\Request');
    }
}
