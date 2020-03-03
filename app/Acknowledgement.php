<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acknowledgement extends Model
{
    protected $table = 'acknowledgements';

    protected $fillable = [
        'post_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
