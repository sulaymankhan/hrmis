<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
class UsersController extends Controller
{
    public function index(Request $r){
        $searchQuery = $r->input('q');
        $users = User::with('center')->orderBy('name','desc');
        if( $searchQuery ){
            $users = User::where(function($query) use ($searchQuery){
                $query->orWhere('name','like','%'.$searchQuery.'%');
                $query->orWhere('email',$searchQuery);
                $query->orWhere('role',$searchQuery);
            });
        }

        return $users->get();
    }

    public function store(UserRequest $r){
        $user                 = new User;
        $user->name           = $r->input('name');
        $user->role           = $r->input('role');
        $user->center_id      = $r->input('center_id');
        $user->email          = $r->input('email');
        $user->password       = bcrypt($r->input('password'));
        $user->save();
        return $user;
    }

    public function update(UserRequest $r){
        $user                 = \App\User::where('id',$r->input('id'))->first();
        if(!$user){
            abort(404);
        }
        $user->name           = $r->input('name');
        $user->role           = $r->input('role');
        $user->center_id      = $r->input('center_id');
        $user->email          = $r->input('email');
        if($r->input('password')){
            $user->password       = bcrypt($r->input('password'));
        }
        
        $user->save();
        return $user;
    }

    public function show($userId){
        $user                 = \App\User::where('id',$userId)->first();
        if(!$user){
            abort(404);
        }
        return $user;
    }


    public function destroy($userId){
        abort(403);
        $user                 = User::where('id',$userId)->first();
        if(!$user){
            abort(404);
        }
        $user->delete();
        return ['message'=>'Deleted!'];
    }

    public function login(Request $r){
        if(\Auth::guard('web')->attempt(['email'=>$r->input('email'),'password'=>$r->input('password')])){
            $user = \Auth::guard('web')->user();
            return [
                'token'=>$user->createToken('login')->accessToken,
                'user'=>$user
            ];
        }
        abort(403);
    }

    public function changePassword(Request $r){
        $user               = $r->user();
        $currentPassword    = $r->input('current_password');
        if( \Auth::guard('web')->attempt(['email'=>$user->email,'password'=>$currentPassword]) ){
            $user->password     = bcrypt($r->input('new_password'));
            $user->save();
            return ['message'=>'پاسورد تغیر داده شده!'];
        }
        return ['message'=>'پاسورد فعلی تان غلط است!'];
    }
}
