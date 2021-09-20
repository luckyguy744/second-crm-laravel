<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    protected $table="ticket";
    protected $fillable = ['ticket_id', 'user_id', 'title', 'msg', 'status', 'state'];

    public function comments(){
    	return $this->hasMany('App\comments', 'ticket_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'id');
    }
}
