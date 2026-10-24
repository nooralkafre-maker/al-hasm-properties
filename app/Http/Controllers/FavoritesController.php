<?php
namespace App\Http\Controllers;
use App\Models\Property;
use Illuminate\Http\Request;
class FavoritesController extends Controller {
 public function index(Request $request){
  $ids=array_values(array_unique(array_map('intval',$request->session()->get('favorite_ids',[]))));
  $properties=Property::published()->whereIn('id',$ids)->latest()->get();
  return view('site.saved',compact('properties'));
 }
 public function toggle(Request $request,Property $property){
  abort_unless($property->status==='published',404);
  $ids=array_values(array_unique(array_map('intval',$request->session()->get('favorite_ids',[]))));
  $ids=in_array($property->id,$ids,true)?array_values(array_diff($ids,[$property->id])):array_slice(array_merge($ids,[$property->id]),-100);
  $request->session()->put('favorite_ids',$ids);
  return back()->with('success',__('Saved list updated.'));
 }
}
