<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class BlogPost extends Model {
 protected $fillable=['slug','title_en','title_ar','body_en','body_ar','excerpt_en','excerpt_ar','image','published_at','status','author_id'];
 protected $casts=['published_at'=>'datetime'];
 public function getRouteKeyName():string{return 'slug';}
 public function author(){return $this->belongsTo(User::class,'author_id');}
 public function getTitleAttribute():string{return (app()->getLocale()==='ar'?$this->title_ar:$this->title_en) ?: $this->title_en ?:'';}
 public function getBodyAttribute():string{return (app()->getLocale()==='ar'?$this->body_ar:$this->body_en) ?: $this->body_en ?:'';}
 public function getExcerptAttribute():string{return (app()->getLocale()==='ar'?$this->excerpt_ar:$this->excerpt_en) ?: $this->excerpt_en ?:'';}
 public function getImageUrlAttribute():string{return $this->image?(str_starts_with($this->image,'https://')?$this->image:Storage::disk('public')->url($this->image)):asset('assets/img/property-default.svg');}
}
