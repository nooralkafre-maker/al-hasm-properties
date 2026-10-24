<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{BlogPost,CmsPage,SiteSetting,User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class ContentController extends Controller {
 private function admin():void{abort_unless(auth()->user()->isAdmin(),403);}
 public function posts(){$this->admin();return view('admin.posts.index',['posts'=>BlogPost::latest()->paginate(15)]);}
 public function postForm(?BlogPost $post=null){$this->admin();return view('admin.posts.form',['post'=>$post??new BlogPost()]);}
 private function savePost(Request $request,?BlogPost $post=null){$this->admin();$data=$request->validate(['title_en'=>'required|string|max:180','title_ar'=>'required|string|max:180','excerpt_en'=>'nullable|string|max:600','excerpt_ar'=>'nullable|string|max:600','body_en'=>'required|string|max:60000','body_ar'=>'required|string|max:60000','status'=>'required|in:draft,published','image_file'=>'nullable|image|max:8192']);$post??=new BlogPost();$post->fill(collect($data)->except('image_file')->all());if(!$post->exists)$post->slug=Str::slug($data['title_en']).'-'.Str::lower(Str::random(5));if(!$post->author_id)$post->author_id=auth()->id();if($request->hasFile('image_file')){$post->image=$request->file('image_file')->store('blog','public');}if($post->status==='published'&&!$post->published_at)$post->published_at=now();$post->save();return redirect()->route('admin.posts.index')->with('success',__('Article saved.'));}
 public function postStore(Request $request){return $this->savePost($request);}
 public function postUpdate(Request $request,BlogPost $post){return $this->savePost($request,$post);}
 public function postDelete(BlogPost $post){$this->admin();if($post->image && !str_starts_with($post->image,'https://'))Storage::disk('public')->delete($post->image);$post->delete();return back()->with('success',__('Article deleted.'));}
 public function agents(){$this->admin();return view('admin.agents.index',['agents'=>User::whereIn('role',['admin','agent'])->latest()->paginate(15)]);}
 public function agentStore(Request $request){$this->admin();$data=$request->validate(['name'=>'required|string|max:120','email'=>'required|email|unique:users,email','phone'=>'nullable|string|max:30','password'=>'required|string|min:12','role'=>'required|in:admin,agent']);User::create($data+['active'=>true]);return back()->with('success',__('Team member created.'));}
 public function agentUpdate(Request $request,User $user){$this->admin();abort_unless(in_array($user->role,['admin','agent'],true),404);$data=$request->validate(['name'=>'required|string|max:120','phone'=>'nullable|string|max:30','role'=>'required|in:admin,agent','active'=>'required|boolean','password'=>'nullable|string|min:12']);if($user->id===auth()->id()&&(!$data['active'] || $data['role']!=='admin'))return back()->withErrors(['role'=>'You cannot deactivate or demote your current admin account.']);if(empty($data['password']))unset($data['password']);$user->update($data);return back()->with('success',__('Team member updated.'));}
 public function settings(){$this->admin();return view('admin.settings.index',['settings'=>SiteSetting::pluck('value','key')->all()]);}
 public function settingsUpdate(Request $request){$this->admin();$data=$request->validate(['company_name'=>'required|string|max:150','tagline_en'=>'nullable|string|max:220','tagline_ar'=>'nullable|string|max:220','phone'=>'nullable|string|max:60','whatsapp'=>'nullable|string|max:60','email'=>'nullable|email|max:150','address'=>'nullable|string|max:300','instagram'=>'nullable|url|max:300','facebook'=>'nullable|url|max:300','hero_title_en'=>'nullable|string|max:200','hero_title_ar'=>'nullable|string|max:200','meta_description_en'=>'nullable|string|max:300','meta_description_ar'=>'nullable|string|max:300']);foreach($data as $key=>$value)SiteSetting::updateOrCreate(['key'=>$key],['value'=>$value]);return back()->with('success',__('Settings saved.'));}
 public function pages(){$this->admin();return view('admin.pages.index',['pages'=>CmsPage::orderBy('slug')->get()]);}
 public function pageEdit(CmsPage $page){$this->admin();return view('admin.pages.form',compact('page'));}
 public function pageUpdate(Request $request,CmsPage $page){$this->admin();$data=$request->validate(['title_en'=>'required|string|max:180','title_ar'=>'required|string|max:180','body_en'=>'nullable|string|max:60000','body_ar'=>'nullable|string|max:60000','published'=>'required|boolean']);$page->update($data);return redirect()->route('admin.pages.index')->with('success',__('Page updated.'));}
}
