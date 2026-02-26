<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(middleware: "auth:sanctum", except: ["index", "show"]),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Post::with(relations: "user")->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): array
    {
        $newPost = new Post();
        $newPost->title = $request->title;
        $newPost->body = $request->body;
        $request->user()->posts()->save($newPost);

        return ["post" => $newPost, "user" => $newPost->user];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Post
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): Post
    {
        $post->update(attributes: $request->all());

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePostRequest $request, Post $post): array
    {
        $post->delete();

        return ["message" => "The post was deleted"];
    }
}
