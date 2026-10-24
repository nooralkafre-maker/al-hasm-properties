<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class SetLocale {
    public function handle(Request $request, Closure $next): Response {
        app()->setLocale(in_array(session('locale'),['ar','en'],true) ? session('locale') : 'en');
        return $next($request);
    }
}
