<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Property,User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class PropertyController extends Controller {
 private function guard(Property $property):void{abort_unless(auth()->user()->isAdmin()||$property->agent_id===auth()->id(),403);}
 public function index(Request $request){
   $query=Property::with('agent');if(!auth()->user()->isAdmin())$query->where('agent_id',auth()->id());
   if($request->filled('q'))$query->where('title_en','like','%'.str_replace(['%','_'],['\\%','\\_'],$request->q).'%');
   if($request->filled('status'))$query->where('status',$request->status);
   return view('admin.properties.index',['properties'=>$query->latest()->paginate(12)->withQueryString()]);
 }
 public function create(){return view('admin.properties.form',['property'=>new Property(),'agents'=>User::whereIn('role',['agent','admin'])->where('active',true)->get()]);}
 public function edit(Property $property){$this->guard($property);return view('admin.properties.form',['property'=>$property,'agents'=>User::whereIn('role',['agent','admin'])->where('active',true)->get()]);}
 private function rules():array{return [
 'title_en'=>'required|string|max:180','title_ar'=>'required|string|max:180','kind'=>'required|in:sale,rent,off_plan','type'=>'required|in:apartment,villa,townhouse,penthouse,commercial,land',
 'status'=>'required|in:draft,published,sold,rented,archived','price'=>'required|numeric|min:0|max:999999999999','price_period'=>'required|in:total,monthly,yearly','city'=>'required|string|max:100','area'=>'required|string|max:100','address'=>'nullable|string|max:255',
 'latitude'=>'nullable|numeric|between:-90,90','longitude'=>'nullable|numeric|between:-180,180','bedrooms'=>'required|integer|between:0,100','bathrooms'=>'required|integer|between:0,100','parking'=>'required|integer|between:0,100','area_sqft'=>'required|integer|min:0','year_built'=>'nullable|integer|between:1900,2100',
 'description_en'=>'nullable|string|max:25000','description_ar'=>'nullable|string|max:25000','amenities_text'=>'nullable|string|max:2000','featured'=>'nullable|boolean','agent_id'=>'nullable|exists:users,id',
 'video_url'=>'nullable|url|max:2000','virtual_tour_url'=>'nullable|url|max:2000','cover'=>'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:8192','gallery_files'=>'nullable|array|max:15','gallery_files.*'=>'image|mimes:jpg,jpeg,png,webp,avif|max:8192','remove_gallery'=>'nullable|array', 'remove_gallery.*'=>'string|max:2048',
 ];}
 private function persist(Request $request,?Property $property=null){
    $data=$request->validate($this->rules());$editing=(bool)$property;
    $property??=new Property();
    $data['featured']=$request->boolean('featured');
    $data['amenities']=array_values(array_filter(array_map('trim',explode(',',(string)($data['amenities_text']??'')))));
    unset($data['amenities_text'],$data['cover'],$data['gallery_files'],$data['remove_gallery']);
    if(!auth()->user()->isAdmin())$data['agent_id']=auth()->id();
    if(!$data['agent_id'])$data['agent_id']=auth()->id();
    if(!$editing){$property->slug=Str::slug($data['title_en']).'-'.Str::lower(Str::random(6));$property->reference='AH-'.strtoupper(Str::random(8));}
    $property->fill($data);
    if($request->hasFile('cover')){
       if($editing && $property->cover_image && !str_starts_with($property->cover_image,'https://'))Storage::disk('public')->delete($property->cover_image);
       $property->cover_image=$request->file('cover')->store('properties','public');
    }
    $gallery=$property->gallery??[];
    foreach($request->input('remove_gallery',[]) as $path){if(in_array($path,$gallery,true)){if(!str_starts_with($path,'https://'))Storage::disk('public')->delete($path);$gallery=array_values(array_diff($gallery,[$path]));}}
    foreach($request->file('gallery_files',[]) as $file)$gallery[]=$file->store('properties','public');
    $property->gallery=$gallery;$property->save();
    return redirect()->route('admin.properties.index')->with('success',__('Property saved successfully.'));
 }
 public function store(Request $request){return $this->persist($request);}
 public function update(Request $request,Property $property){$this->guard($property);return $this->persist($request,$property);}
 public function destroy(Property $property){$this->guard($property);
  $paths=array_filter(array_merge([$property->cover_image],$property->gallery??[]),fn($p)=>!str_starts_with((string)$p,'https://'));
  Storage::disk('public')->delete($paths);$property->delete();return back()->with('success',__('Property deleted.'));
 }
}
