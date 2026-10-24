<?php
use App\Models\Property;
use Illuminate\Support\Facades\Route;
Route::get('/v1/properties',function () {return Property::published()->latest()->paginate(12)->through(fn($p)=>['id'=>$p->id,'title'=>$p->title,'slug'=>$p->slug,'price'=>$p->price,'kind'=>$p->kind,'city'=>$p->city,'image'=>$p->image_url]);});
Route::get('/v1/properties/{property:slug}',function(Property $property){abort_unless($property->status==='published',404);return response()->json(['data'=>['id'=>$property->id,'title'=>$property->title,'description'=>$property->description,'price'=>$property->price,'kind'=>$property->kind,'type'=>$property->type,'city'=>$property->city,'area'=>$property->area,'bedrooms'=>$property->bedrooms,'bathrooms'=>$property->bathrooms,'area_sqft'=>$property->area_sqft,'image'=>$property->image_url]]);});
