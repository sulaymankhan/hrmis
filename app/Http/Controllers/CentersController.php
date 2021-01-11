<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Center;
use App\Http\Requests\CenterRequest;
class CentersController extends Controller
{
    public function index(Request $r){
        $searchQuery = $r->input('q');
        $centers = Center::orderBy('name','desc');
        if( $searchQuery ){
            $centers = Center::where(function($query) use ($searchQuery){
                $query->orWhere('name','like','%'.$searchQuery.'%');
                $query->orWhere('district',$searchQuery);
                $query->orWhere('province',$searchQuery);
                $query->orWhere('country',$searchQuery);
            });
        }

        return $centers->get();
    }

    public function store(CenterRequest $r){
        $center                 = new Center;
        $center->name           = $r->input('name');
        $center->district       = $r->input('district');
        $center->province       = $r->input('province');
        $center->country        = $r->input('country');
        $center->save();
        return $center;
    }

    public function update(CenterRequest $r){
        $center                 = Center::where('id',$r->input('id'))->first();
        if(!$center){
            abort(404);
        }
        $center->name           = $r->input('name');
        $center->district       = $r->input('district');
        $center->province       = $r->input('province');
        $center->country        = $r->input('country');
        $center->save();
        return $center;
    }

    public function show($centerId){
        $center                 = Center::where('id',$centerId)->first();
        if(!$center){
            abort(404);
        }
     
        return $center;
    }

    public function destroy($centerId){
        $center                 = Center::where('id',$centerId)->first();
        if(!$center){
            abort(404);
        }
        $center->delete();
        return ['message'=>'Deleted!'];
    }
}
