<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
{

    public function index(Request $r)
    {
        $Log = new \App\Log;
        $searchQuery = $r->input('q', '');
        $uniqueField = $r->input('unique', false);

        if (in_array($r->user()->role, ['admin', 'manager'])) {

            if ($searchQuery != "") {
                $Log = $Log->where(function ($query) use ($searchQuery) {
                    $query->orWhere('description', 'like',  "%" . $searchQuery . "%");
                    $query->orWhere('created_at', 'like', '%' . $searchQuery . '%');
                });
            }

            if ($uniqueField) {
                $logResult = \App\Log::distinct($uniqueField)->orderBy($uniqueField)->get();
                return $logResult;
            }
        }
        return $Log->take(100)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\logs  $logId
     * @return \Illuminate\Http\Response
     */
    
    public function show($logId)
    {
        $log                 = \App\Log::where('id', $logId)->first();
        if (!$log) {
            abort(404);
        }
        return $log;
    }
}
