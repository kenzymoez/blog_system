<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
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
        $posts = Post::all();
        return response()->json([
            'success'=>true, 
            // 'data'=> $posts
            'data'=> PostResource::collection($posts)
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
        Post::with("user")->findOrFail($id);
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
