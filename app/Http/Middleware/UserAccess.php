<?php

namespace App\Http\Middleware;

use Closure;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role1=null,$role2=null,$role3=null)
    {
        $roles=[$role1,$role2,$role3];
        if($request->user() && in_array($request->user()->role, $roles ) == false) {
           abort(403);
        }
        return $next($request);
    }
}
