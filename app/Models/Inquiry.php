<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Inquiry extends Model {
 protected $fillable=['property_id','name','email','phone','purpose','message','status','source','assigned_to','notes'];
 public function property(){return $this->belongsTo(Property::class);}
 public function assignee(){return $this->belongsTo(User::class,'assigned_to');}
}
