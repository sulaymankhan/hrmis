<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $result = new \App\Post;
        $searchQuery = $r->input('q', '');
        $uniqueField = $r->input('unique',false);

        if (in_array($r->user()->role, ['admin', 'manager'])) {

            if ($searchQuery != "") {
                $result = $result->where(function ($query) use ($searchQuery) {
                    $query->orWhere('post_code', 'like', $searchQuery . "%");
                    $query->orWhere('name', 'like', '%' . $searchQuery . '%');
                });
            }

            if($uniqueField){
                $posts = \App\Post::distinct($uniqueField)->orderBy($uniqueField)->get();
                return $posts;
            }
        }
        if($r->user()->role == 'center_manager'){
            $result = $result->select('id','name','post_code','type','ddg','center_id','project','location');
        }
        return $result->take(100)->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $r)
    {

        $post                        = new Post;
        $post->name                  = $r->input('name');
        $post->post_code             = $r->input('post_code');
        $post->salary                = $r->input('salary');
        $post->type                  = $r->input('type');
        $post->ddg                   = $r->input('ddg');
        $post->center_id             = $r->input('center_id');
        $post->project               = $r->input('project');
        $post->location              = $r->input('location');
        $post->grade                 = $r->input('grade');
        $post->step                  = $r->input('step');
        $post->save();
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($postId)
    {
        $post                 = \App\Post::where('id', $postId)->first();
        if (!$post) {
            abort(404);
        }
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $r)
    {
        $post                 = \App\Post::where('id', $r->input('id'))->first();
        if (empty($post)) {
            abort(404);
        }
        $post->name                  = $r->input('name');
        $post->post_code             = $r->input('post_code');
        $post->salary                = $r->input('salary');
        $post->type                  = $r->input('type');
        $post->ddg                   = $r->input('ddg');
        $post->center_id             = $r->input('center_id');
        $post->project               = $r->input('project');
        $post->location              = $r->input('location');
        $post->grade                 = $r->input('grade');
        $post->step                  = $r->input('step');
        $post->save();
        return $post;
    }

    public function destroy($postId)
    {
        abort(403);
        $post                 = \App\Post::where('id', $postId)->first();
        if (!$post) {
            abort(404);
        }
        $post->delete();
        return ['message' => 'Deleted!'];
    }

    public function filterData(Request $r){
        $data=[];
        if(!$r->input('filters',false)){
            $data['centers']= \App\Post::getUniqueCenters();
            $data['ddg']= \App\Post::getUniqueDdg();
            return $data;
        }else{
            foreach($r->input('filters') as $f):
                if($f['name'] == 'ddg'){
                    $data['centers']= \App\Post::getUniqueCenters($f['info']);
                    $data['ddg']= \App\Post::getUniqueDdg();
                }
            endforeach;
            return $data;
        }
   

        return $data;
    }
}
