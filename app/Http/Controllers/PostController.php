<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use Cache;
use Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use app\Models\post;

class PostController extends Controller
{
    public function __construct(){
        $this->authorizeResource(Post::class,"posts");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts=Cache::get("AllPosts");
        // if(!$posts){
        //     $posts=Post::all();
        //     Cache::put("AllPosts",$posts,3600);
        // }
        // $posts = Post::all();
        $posts = Cache::remember("AllPosts",3600,function(){
            return Post::all();
        });

        return response()->json([
            'success'=>true, 
            'data'=> $posts
            // 'data'=> PostResource::collection($posts)
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        Gate::authorize('IsUser');
        Post::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $this->authorize('view', Post::class);
            $posts = Cache::remember("Post".$id,3600,function()use($id){
            return Post::with("user")->findOrFail($id);
        });

        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        //direct call
        // $this->authorize('update', $post);
        $post->updated($request);
        Cache::forget("AllPosts");
        Cache::forget("Post".$id);
        //php artisan cache:clear or
        Cache::flush();
        return response()->json([
            'message'=> 'Post updated'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::delete($id);
    }
}
