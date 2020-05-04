<?php
namespace App\Http\Middleware;
use Closure;

class ForLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('id_user')) {
             return $next($request);
        }
        else {
            return redirect('/');
        }
       
    }
}