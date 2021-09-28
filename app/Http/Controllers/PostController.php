<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PostResource;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse(PostResource::collection($posts), 'Posts fetched.');

        //return Post::orderByDesc('created_at')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(Post::create($request->all())){
            return response()->json([
                'success' => 'Post créée avec succès'
            ], 200);
        }

        //TODO Ajout gestion erreur
        //TODO corrélation avec 'created_by'
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return Response
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Post  $post
     * @return JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        if($post->update($request->all())){
            return response()->json([
                'success' => 'Post mis à jour avec succès'
            ], 200);
        }
        //TODO Ajout gestion erreur

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        if($post->delete()) return response('Post supprimé', 200);
    }

    public function my_posts(Request $request, int $id){
        $posts = Post::all();
        return response()->json([
            'success' => $request->user()
        ], 200);
    }
}
