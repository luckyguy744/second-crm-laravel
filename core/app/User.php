<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;

class User extends Authenticatable
{
    use Notifiable;
    

    protected $table = 'users';
     

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstname','lastname', 'email', 'pwd', 'phone', 'username', 'status', 'currency', 'referal', 'reg_date', 'act_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pwd', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
      return $this->pwd;
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    public function ticket(){
        return $this->hasMany('App\ticket', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\comments', 'sender_id');
    }

}
