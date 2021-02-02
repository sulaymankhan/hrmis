<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public static function getUniqueCenters($filterValue=false){
        $center_ids = \App\Post::distinct('center_id');
        if($filterValue){
            foreach($filterValue as $v):
                $center_ids = $center_ids->orWhere('ddg',$v['value']);
            endforeach;
        }
        $center_ids=$center_ids->get()->map(function($p){
            return $p->center_id;
        })->toArray();

        return \App\Center::whereIn('id',$center_ids)->get()->map(function($c){
            return [
                'id'=>$c->id,
                'name'=>$c->name
            ];
        });
    }
    public static function getUniqueDdg(){
        $ddgs = \DB::table('posts')
        ->select('ddg')
        ->groupBy('ddg')
        ->get()->map(function($p){
            return $p->ddg;
        })->toArray();
        return $ddgs;
    }

    public static function updateHasEmployee(){
        $posts = \App\Post::get();
        foreach($posts as $p):
            $e = \App\Employee::where('post_id',$p->id)->exists();
            if($e){
                $p->has_employee=true;
            }else{
                $p->has_employee=true;
            }

            $p->save();

        endforeach;
    }

    
}
