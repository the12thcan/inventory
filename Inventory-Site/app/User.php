<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;

// TODO: POSSIBLY USE LARAVEL PASSPORT FOR AUTHENTICATION FOR REST API

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users'; // table name
    protected $primaryKey = 'id'; // primary key
    public $timestamps = true; // timestamps

    /**
     * Defines the relationship that the user has with the transaction in the Order_Transactions table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        // Define the table relationships
        return $this->hasMany('App\Transaction');
    }

    /**
     * Defines the relationship that a user has with the Member_Position in the database table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo('App\Member_Position');
    }
}
