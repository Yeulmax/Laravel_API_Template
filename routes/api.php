<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\DB;

/*
|-------------------------------------------------------------------------------
| Création de compte
|-------------------------------------------------------------------------------
| URL:            /api/register
| Controller:     AuthController@signup
| Method:         POST
| Description:    Enregistre un utilisateur en BDD
*/
Route::post('register', [AuthController::class, 'signup']);

/*
|-------------------------------------------------------------------------------
| Authentification
|-------------------------------------------------------------------------------
| URL:            /api/login
| Controller:     AuthController@signin
| Method:         POST
| Description:    Connexion utilisateur
*/
Route::post('login', [AuthController::class, 'signin']);

/*
|-------------------------------------------------------------------------------
| Profil
|-------------------------------------------------------------------------------
| URL:            /api/user
| Controller:
| Method:         POST
| Description:    Retourne le profil de l'utilisateur authentifié
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|-------------------------------------------------------------------------------
| PostController
|-------------------------------------------------------------------------------
| URL:            /api/posts[/{id}]
| Controller:     PostController
| Method:         GET/PATCH
| Description:    Accès à l'index et la modification de post
*/
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('posts', PostController::class);
});

/*
|-------------------------------------------------------------------------------
| Posts de l'utilisateur actuel
|-------------------------------------------------------------------------------
| URL:            /api/my_posts
| Controller:     PostController@findByCurrentUser
| Method:         GET
| Description:    Retourne les posts crée par l'utilisateur authentifié
*/
Route::middleware('auth:sanctum')->group(function(){
    Route::get('my_posts', [PostController::class, 'findByCurrentUser']);
});

/*
|-------------------------------------------------------------------------------
| Posts par id_utilisateur
|-------------------------------------------------------------------------------
| URL:            /api/posts/user/{id}
| Controller:     PostController@findByUserId
| Method:         GET
| Description:    Retourne les posts filtré par un id d'utilisateur
*/
Route::middleware('auth:sanctum')->group(function(){
    Route::get('posts/user/{id}', [PostController::class, 'findByUserId']);
});

/*
|-------------------------------------------------------------------------------
| Posts par titre
|-------------------------------------------------------------------------------
| URL:            /api/posts/title/{titre}
| Controller:     PostController@findByTitle
| Method:         GET
| Description:    Retourne les posts publié ET filtré par un titre
*/
// Post trié par titre
Route::middleware('auth:sanctum')->group(function(){
    Route::get('posts/title/{title}', [PostController::class, 'findByTitle']);
});
