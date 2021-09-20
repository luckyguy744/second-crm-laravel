<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    protected $table="comments";
    protected $fillable = ['ticket_id', 'message', 'sender', 'sender_id'];
    public function ticket(){
    	return $this->belongsTo('App\ticket', 'id');
    }
    public function user(){
    	return $this->belongsTo('App\User', 'sender_id');
    }
}
