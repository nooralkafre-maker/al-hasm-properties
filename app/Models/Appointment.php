<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Appointment extends Model {
 protected $fillable=['property_id','name','email','phone','scheduled_at','status','notes'];
 protected $casts=['scheduled_at'=>'datetime'];
 public function property(){return $this->belongsTo(Property::class);}
}
