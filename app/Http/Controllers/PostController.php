<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use app\Models\post;

class PostController extends Controller
{
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
        post::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        post::with("user")->findOrFail($id);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        post::findOrFail($id)->updated($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        post::delete($id);
    }
}
