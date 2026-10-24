<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Contract,Payment,Property};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ContractsController extends Controller {
 private function permission(Contract $contract):void{abort_unless(auth()->user()->isAdmin()||$contract->property?->agent_id===auth()->id(),403);}
 private function properties(){return Property::query()->when(!auth()->user()->isAdmin(),fn($q)=>$q->where('agent_id',auth()->id()))->orderBy('title_en')->get();}
 private function contracts(){return Contract::with('property')->when(!auth()->user()->isAdmin(),fn($q)=>$q->whereHas('property',fn($p)=>$p->where('agent_id',auth()->id())));}
 public function index(){return view('admin.contracts.index',['contracts'=>$this->contracts()->latest()->paginate(15)]);}
 public function create(){return view('admin.contracts.form',['contract'=>new Contract(),'properties'=>$this->properties()]);}
 public function edit(Contract $contract){$this->permission($contract);return view('admin.contracts.form',['contract'=>$contract,'properties'=>$this->properties()]);}
 private function save(Request $request,?Contract $contract=null){$data=$request->validate(['property_id'=>'required|exists:properties,id','client_name'=>'required|string|max:150','client_email'=>'nullable|email|max:150','client_phone'=>'nullable|string|max:50','type'=>'required|in:sale,rent','amount'=>'required|numeric|min:0','starts_on'=>'nullable|date','ends_on'=>'nullable|date|after_or_equal:starts_on','status'=>'required|in:draft,signed,completed,cancelled','notes'=>'nullable|string|max:3000']);
  $property=Property::findOrFail($data['property_id']);abort_unless(auth()->user()->isAdmin()||$property->agent_id===auth()->id(),403);
  $contract??=new Contract();if(!$contract->exists){$contract->contract_no='ALH-'.now()->format('ymd').'-'.strtoupper(Str::random(5));$contract->created_by=auth()->id();}$contract->fill($data)->save();return redirect()->route('admin.contracts.index')->with('success',__('Contract saved.'));}
 public function store(Request $request){return $this->save($request);}
 public function update(Request $request,Contract $contract){$this->permission($contract);return $this->save($request,$contract);}
 public function destroy(Contract $contract){$this->permission($contract);abort_unless(auth()->user()->isAdmin(),403);$contract->delete();return back()->with('success',__('Contract deleted.'));}
 public function payments(){return view('admin.payments.index',['payments'=>Payment::with('contract.property')->when(!auth()->user()->isAdmin(),fn($q)=>$q->whereHas('contract.property',fn($p)=>$p->where('agent_id',auth()->id())))->latest()->paginate(20),'contracts'=>$this->contracts()->whereIn('status',['draft','signed','completed'])->get()]);}
 public function paymentStore(Request $request){$data=$request->validate(['contract_id'=>'required|exists:contracts,id','amount'=>'required|numeric|min:0.01','paid_on'=>'required|date','category'=>'required|string|max:70','method'=>'required|in:cash,bank_transfer,cheque,card,other','status'=>'required|in:pending,received,refunded','reference'=>'nullable|string|max:120','notes'=>'nullable|string|max:3000']);$contract=Contract::with('property')->findOrFail($data['contract_id']);$this->permission($contract);Payment::create($data);return back()->with('success',__('Payment record created.'));}
 public function paymentUpdate(Request $request,Payment $payment){$this->permission($payment->contract);$payment->update($request->validate(['status'=>'required|in:pending,received,refunded']));return back()->with('success',__('Payment status updated.'));}
 public function paymentDelete(Payment $payment){$this->permission($payment->contract);abort_unless(auth()->user()->isAdmin(),403);$payment->delete();return back()->with('success',__('Payment record deleted.'));}
}
