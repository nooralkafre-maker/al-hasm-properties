<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller {
 public function show(){return view('auth.login');}
 public function login(Request $request){
  $data=$request->validate(['email'=>'required|email','password'=>'required|string','remember'=>'nullable|boolean']);
  $key='login:'.sha1(strtolower($data['email']).'|'.$request->ip());
  if(RateLimiter::tooManyAttempts($key,5)) throw ValidationException::withMessages(['email'=>__('Too many attempts. Try again later.')]);
  if(!Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'active'=>true],(bool)($data['remember']??false))){RateLimiter::hit($key,60);throw ValidationException::withMessages(['email'=>__('Invalid credentials.')]);}
  RateLimiter::clear($key);$request->session()->regenerate();
  return redirect()->intended(auth()->user()->role==='client'?route('properties.index'):route('admin.dashboard'));
 }
 public function logout(Request $request){Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return redirect()->route('home');}
}
