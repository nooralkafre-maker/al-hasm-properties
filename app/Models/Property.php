<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Property extends Model {
 protected $fillable=['title_en','title_ar','slug','reference','kind','type','status','price','price_period','city','area','address','latitude','longitude','bedrooms','bathrooms','parking','area_sqft','year_built','description_en','description_ar','amenities','cover_image','gallery','video_url','virtual_tour_url','featured','agent_id','views'];
 protected $casts=['amenities'=>'array','gallery'=>'array','featured'=>'boolean','price'=>'decimal:2','latitude'=>'decimal:7','longitude'=>'decimal:7'];
 public function getRouteKeyName():string{return 'slug';}
 public function scopePublished($query){return $query->where('status','published');}
 public function agent(){return $this->belongsTo(User::class,'agent_id');}
 public function inquiries(){return $this->hasMany(Inquiry::class);}
 public function appointments(){return $this->hasMany(Appointment::class);}
 public function getTitleAttribute():string{return (app()->getLocale()==='ar' ? $this->title_ar : $this->title_en) ?: $this->title_en ?: $this->title_ar ?: '';}
 public function getDescriptionAttribute():string{return (app()->getLocale()==='ar' ? $this->description_ar : $this->description_en) ?: $this->description_en ?: $this->description_ar ?: '';}
 public function getImageUrlAttribute():string{
    if (!$this->cover_image) return asset('assets/img/property-default.svg');
    if (str_starts_with($this->cover_image,'https://')) return $this->cover_image;
    return Storage::disk('public')->url($this->cover_image);
 }
 public function getImagesAttribute():array{
    return collect($this->gallery??[])->map(function($path){return str_starts_with($path,'https://')?$path:Storage::disk('public')->url($path);})->all();
 }
}
