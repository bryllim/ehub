<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'title', 'description', 'status', 'deadline', 'user_id', 'department_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
