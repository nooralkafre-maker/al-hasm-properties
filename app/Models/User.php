<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
 use Notifiable;
 protected $fillable=['name','email','phone','password','role','active','bio','photo'];
 protected $hidden=['password','remember_token'];
 protected function casts():array{return ['email_verified_at'=>'datetime','password'=>'hashed','active'=>'boolean'];}
 public function properties(){return $this->hasMany(Property::class,'agent_id');}
 public function favorites(){return $this->belongsToMany(Property::class,'favorites')->withTimestamps();}
 public function isAdmin():bool{return $this->role==='admin';}
}
