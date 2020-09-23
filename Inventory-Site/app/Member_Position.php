<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member_Position extends Model
{
    protected $table = 'Member_Position'; // table name
    protected $primaryKey = 'id'; // primary key
    public $timestamps = true; // timestamps

    public function user()
    {
        $this->hasMany('App\User');
    }
}
