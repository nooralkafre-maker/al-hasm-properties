<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CmsPage extends Model {
 protected $fillable=['slug','title_en','title_ar','body_en','body_ar','published'];
 protected $casts=['published'=>'boolean'];
 public function getTitleAttribute():string{return app()->getLocale()==='ar'?$this->title_ar:$this->title_en;}
 public function getBodyAttribute():string{return app()->getLocale()==='ar'?$this->body_ar:$this->body_en;}
}
