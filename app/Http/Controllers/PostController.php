<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\DB;

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
        }else{
            return response()->json([
                'error' => 'Erreur lors de la mise à jour'
            ], 500);
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

    /**
     * Renvoie les posts de l'utilisateur authentifié
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function findByCurrentUser(Request $request)
    {
        $posts = Post::all()->where('created_by', $request->user()->id);

        return response()->json([
            'success' => $posts
        ], 200);
    }

    /**
     * Renvoie les posts filtré par id d'utilisateur
     *
     * @return JsonResponse
     */
    public function findByUserId(int $id)
    {
        $posts = Post::all()->where('created_by', $id);

        return response()->json([
            'success' => $posts
        ], 200);
    }

    /**
     * Renvoie les posts publié et filtré par titre
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function findByTitle(Request $request, string $title)
    {

        /* Ne semble pas fonctionner sur cette version de Laravel, à approfondir
         * Solution de contournement: Création d'une requête RAW
         *
         * $posts = Post::all();
         * $postsFiltre = $posts->where('title', 'LIKE', '%'.$title.'%')->where('is_public','IS', TRUE) ;
         */

        $postsFiltre = DB::select( DB::raw("SELECT * FROM posts WHERE title LIKE "."'%". $title ."%' AND is_public IS TRUE"));

        return response()->json([
            'success' => $postsFiltre
        ], 200);
    }
}
