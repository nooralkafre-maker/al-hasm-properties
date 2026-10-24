<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
 protected $fillable=['contract_id','amount','paid_on','category','method','status','reference','notes'];
 protected $casts=['paid_on'=>'date','amount'=>'decimal:2'];
 public function contract(){return $this->belongsTo(Contract::class);}
}
