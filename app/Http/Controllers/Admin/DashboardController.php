<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Property,Inquiry,Appointment,User};
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller {
 public function index(){
  $p=Property::query();$i=Inquiry::query();$a=Appointment::query();
  if(!auth()->user()->isAdmin()){$p->where('agent_id',auth()->id());$i->where('assigned_to',auth()->id());$a->whereHas('property',fn($q)=>$q->where('agent_id',auth()->id()));}
  return view('admin.dashboard',[
   'metrics'=>['total'=>(clone $p)->count(),'sale'=>(clone $p)->where('kind','sale')->count(),'rent'=>(clone $p)->where('kind','rent')->count(),'leads'=>(clone $i)->count(),'new'=>(clone $i)->where('status','new')->count(),'viewings'=>(clone $a)->count()],
   'recentProperties'=>(clone $p)->latest()->take(5)->get(),
   'recentInquiries'=>(clone $i)->with('property')->latest()->take(6)->get(),
   'trend'=>Inquiry::where('created_at','>=',now()->subMonths(6))->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, count(*) as total')->groupBy('ym')->orderBy('ym')->pluck('total','ym')->all(),
   'kinds'=>(clone $p)->select('kind',DB::raw('count(*) as total'))->groupBy('kind')->pluck('total','kind')->all(),
  ]);
 }
 public function reports(){
    abort_unless(auth()->user()->isAdmin(),403);
    $data=['properties'=>Property::count(),'published'=>Property::published()->count(),'inquiries'=>Inquiry::count(),'appointments'=>Appointment::count(),'agents'=>User::where('role','agent')->count(),'inventoryValue'=>Property::where('kind','sale')->where('status','published')->sum('price')];
    return view('admin.reports',compact('data'));
 }
}
