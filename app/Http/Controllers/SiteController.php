<?php
namespace App\Http\Controllers;
use App\Models\{Property,BlogPost,CmsPage,Inquiry,Appointment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
class SiteController extends Controller {
 public function home(){
   return view('site.home',[
      'featured'=>Property::published()->where('featured',true)->latest()->take(6)->get(),
      'newest'=>Property::published()->latest()->take(6)->get(),
      'stats'=>['properties'=>Property::published()->count(),'sale'=>Property::published()->where('kind','sale')->count(),'rent'=>Property::published()->where('kind','rent')->count(),'cities'=>Property::published()->distinct()->count('city')],
      'posts'=>BlogPost::where('status','published')->latest('published_at')->take(3)->get(),
   ]);
 }
 public function listing(Request $request){
   $filters=$request->validate(['q'=>'nullable|string|max:90','kind'=>'nullable|in:sale,rent,off_plan','type'=>'nullable|in:apartment,villa,townhouse,penthouse,commercial,land','city'=>'nullable|string|max:80','min'=>'nullable|numeric|min:0','max'=>'nullable|numeric|min:0','beds'=>'nullable|integer|min:0|max:20','sort'=>'nullable|in:latest,price_asc,price_desc,most_viewed']);
   $query=Property::published()->with('agent');
   if(!empty($filters['q'])) $query->where(function($q)use($filters){$s='%'.$filters['q'].'%';$q->where('title_en','like',$s)->orWhere('title_ar','like',$s)->orWhere('area','like',$s)->orWhere('reference','like',$s);});
   foreach(['kind','type','city'] as $field) if(!empty($filters[$field])) $query->where($field,$filters[$field]);
   if(isset($filters['min']))$query->where('price','>=',$filters['min']);
   if(isset($filters['max']))$query->where('price','<=',$filters['max']);
   if(isset($filters['beds']))$query->where('bedrooms','>=',$filters['beds']);
   match($filters['sort']??'latest'){'price_asc'=>$query->orderBy('price'),'price_desc'=>$query->orderByDesc('price'),'most_viewed'=>$query->orderByDesc('views'),default=>$query->latest()};
   return view('site.listing',['properties'=>$query->paginate(9)->withQueryString(),'cities'=>Property::published()->distinct()->orderBy('city')->pluck('city')]);
 }
 public function detail(Property $property){
   abort_unless($property->status==='published',404);
   $property->increment('views');
   $similar=Property::published()->whereKeyNot($property->id)->where('type',$property->type)->take(3)->get();
   return view('site.detail',compact('property','similar'));
 }
 public function info(string $slug){
   if($slug==='about') return redirect()->route('about');
   if($slug==='services') return redirect()->route('services');
   abort_unless(in_array($slug,['about','services','privacy','terms'],true),404);
   $page=CmsPage::where('slug',$slug)->where('published',true)->firstOrFail();
   return view('site.page',compact('page'));
 }
 public function about(){return view('site.about');}
 public function services(){return view('site.services');}
 public function contact(){return view('site.contact');}
 public function posts(){return view('site.blog',['posts'=>BlogPost::where('status','published')->latest('published_at')->paginate(9)]);}
 public function post(BlogPost $post){abort_unless($post->status==='published',404);return view('site.post',compact('post'));}
 public function inquiry(Request $request){
    $data=$request->validate(['property_id'=>'nullable|exists:properties,id','name'=>'required|string|max:100','email'=>'nullable|email|max:150','phone'=>'required|string|max:25','purpose'=>'required|in:buy,rent,invest,general','message'=>'required|string|min:10|max:4000','website'=>'nullable|max:0']);
    unset($data['website']);$data['source']='website';
    Inquiry::create($data);
    return back()->with('success',__('Thank you! Your inquiry has been received.'));
 }
 public function appointment(Request $request){
    $data=$request->validate(['property_id'=>'required|exists:properties,id','name'=>'required|string|max:100','email'=>'nullable|email|max:150','phone'=>'required|string|max:25','scheduled_at'=>'required|date|after:now','notes'=>'nullable|string|max:1500','website'=>'nullable|max:0']);
    unset($data['website']);Appointment::create($data);
    return back()->with('success',__('Viewing requested. We will confirm your appointment.'));
 }
 public function subscribe(Request $request){
    $data=$request->validate(['email'=>'required|email|max:150']);
    DB::table('subscribers')->insertOrIgnore(['email'=>$data['email'],'created_at'=>now(),'updated_at'=>now()]);
    return back()->with('success',__('Subscribed successfully.'));
 }
 public function sitemap(){
   $urls=collect([url('/'),route('properties.index'),route('about'),route('services'),route('contact'),route('blog.index')]);
   foreach(Property::published()->get(['slug']) as $p)$urls->push(route('properties.show',$p));
   foreach(BlogPost::where('status','published')->get(['slug']) as $p)$urls->push(route('blog.show',$p));
   $xml='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
   foreach($urls as $link)$xml.='<url><loc>'.htmlspecialchars($link,ENT_XML1,'UTF-8').'</loc></url>';
   return response($xml.'</urlset>',200,['Content-Type'=>'application/xml']);
 }
}
