<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public function servicerequest()
    {
        return $this->hasMany('App\ServiceRequest');
    }
}
