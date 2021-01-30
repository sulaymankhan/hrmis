<?php

namespace App\Http\Middleware;

use Illuminate\Support\Collection;
use App\Log;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public $previouseData;



    public function handle($request, Closure $next)
    {
        $log = json_decode(collect($request->server()));
        if ($request->user() && $request->user()->role) {
            if ($log->REQUEST_METHOD == strtoupper("put")) {
                /** * used for update method only */
                $this->previouseData = $this->getPreviouseDataModel($request);
                $this->setData($request);
            } else {
                /** used for other post methods */
                $this->setData($request);
            }
        }
        return $next($request);
    }



    public function setData($request)
    {
        $logRequest = json_decode(collect($request->server()));
        $logfile                    = new Log;
        $logfile->description       = $logRequest->REQUEST_URI;
        $logfile->requested_url     = $request->fullUrl();
        $logfile->previouse_data     = $this->previouseData;
        $logfile->request_data      = $request->all();
        $logfile->requested_method  =  $logRequest->REQUEST_METHOD;
        $logfile->user_id           = Auth::id();
        $logfile->save();
    }

    public function getPreviouseDataModel($request)
    {
        if (strpos("employees", strtolower($request->fullUrl())) !== -1) {
            $employee = \App\Employee::where('id', $request->input('id'))->first();
            return $employee;
        } elseif (strpos("centers", strtolower($request->fullUrl())) !== -1) {
            $center = \App\Center::where('id', $request->input('id'))->first();
            return $center;
        }
        if (strpos("posts", strtolower($request->fullUrl())) !== -1) {
            $post = \App\Post::where('id', $request->input('id'))->first();
            return $post;
        }
    }
}
