<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Contract extends Model {
 protected $fillable=['contract_no','property_id','created_by','client_name','client_email','client_phone','type','amount','starts_on','ends_on','status','notes'];
 protected $casts=['starts_on'=>'date','ends_on'=>'date','amount'=>'decimal:2'];
 public function property(){return $this->belongsTo(Property::class);}
 public function payments(){return $this->hasMany(Payment::class);}
}
