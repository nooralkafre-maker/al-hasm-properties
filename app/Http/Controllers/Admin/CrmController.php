<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Inquiry,Appointment,User};
use Illuminate\Http\Request;
class CrmController extends Controller {
 private function inquiryAccess(Inquiry $lead):void{abort_unless(auth()->user()->isAdmin() || $lead->assigned_to===auth()->id() || $lead->property?->agent_id===auth()->id(),403);}
 public function inquiries(Request $request){$q=Inquiry::with('property','assignee');if(!auth()->user()->isAdmin())$q->where(fn($x)=>$x->where('assigned_to',auth()->id())->orWhereHas('property',fn($p)=>$p->where('agent_id',auth()->id())));if($request->filled('status'))$q->where('status',$request->status);return view('admin.inquiries.index',['leads'=>$q->latest()->paginate(15),'agents'=>User::whereIn('role',['admin','agent'])->get()]);}
 public function inquiryUpdate(Request $request,Inquiry $inquiry){$this->inquiryAccess($inquiry);$d=$request->validate(['status'=>'required|in:new,contacted,viewing,negotiating,closed','notes'=>'nullable|string|max:4000','assigned_to'=>'nullable|exists:users,id']);if(!auth()->user()->isAdmin())unset($d['assigned_to']);$inquiry->update($d);return back()->with('success',__('Lead updated.'));}
 public function inquiryDelete(Inquiry $inquiry){abort_unless(auth()->user()->isAdmin(),403);$inquiry->delete();return back()->with('success',__('Lead deleted.'));}
 public function appointments(){ $q=Appointment::with('property');if(!auth()->user()->isAdmin())$q->whereHas('property',fn($p)=>$p->where('agent_id',auth()->id()));return view('admin.appointments.index',['appointments'=>$q->latest()->paginate(15)]);}
 public function appointmentUpdate(Request $request,Appointment $appointment){abort_unless(auth()->user()->isAdmin()||$appointment->property?->agent_id===auth()->id(),403);$appointment->update($request->validate(['status'=>'required|in:pending,confirmed,completed,cancelled','notes'=>'nullable|string|max:3000']));return back()->with('success',__('Appointment updated.'));}
 public function appointmentDelete(Appointment $appointment){abort_unless(auth()->user()->isAdmin(),403);$appointment->delete();return back()->with('success',__('Appointment deleted.'));}
}
