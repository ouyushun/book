<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        if(isset($_SERVER['HTTP_REFERER'])){
            $http_referer = $_SERVER['HTTP_REFERER'];
        }else{
            $http_referer = '';
        }
        
        $member = $request->session()->get('member','');
        if($member == null){
            return redirect('login?return_url='.urlencode($http_referer));
        }
        
        return $next($request);
    }
}
