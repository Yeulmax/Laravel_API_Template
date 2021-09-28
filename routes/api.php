<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\DB;
//TODO Doc
//Authentification
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

//Profil de l'utilisateur authentifié
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Liste des posts
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('posts', PostController::class);
});

// Post trié par utilisateur courant
Route::middleware('auth:sanctum')->group(function(){
    Route::get('my_posts', [PostController::class, 'findByCurrentUser']);
});

// Post trié par utilisateur
Route::middleware('auth:sanctum')->group(function(){
    Route::get('posts/user/{id}', [PostController::class, 'findByUserId']);
});

// Post trié par titre
Route::middleware('auth:sanctum')->group(function(){
    Route::get('posts/title/{title}', [PostController::class, 'findByTitle']);
});

//TODO a supprimer
/*
Route::middleware('auth:sanctum')->group(function(){
    Route::resource([AuthController::class, 'signin'];
});

*/
