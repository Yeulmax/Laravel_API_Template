<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//TODO A retirer
//Active les logs de la BDD dans storage/logs
\DB::listen(function($sql) {
    \Log::info($sql->sql);
    \Log::info($sql->bindings);
    \Log::info($sql->time);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//TODO Doc

//Authentification
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

// Liste des posts
Route::middleware('auth:sanctum')->group(function(){
    Route::resource('posts', PostController::class);
});

// Post trié par titre
Route::middleware('auth:sanctum')->group(function(){
    Route::get('posts/title/{title}', [PostController::class, 'findByTitle']);
});

// Post trié par utilisateur
Route::middleware('auth:sanctum')->group(function(){
    Route::get('posts/user/{id}', [PostController::class, 'findByUserId']);
});
// Post trié par utilisateur courant
Route::middleware('auth:sanctum')->group(function(){
    Route::get('my_posts', [PostController::class, 'findByCurrentUser']);
});

//TODO a supprimer
/*
Route::middleware('auth:sanctum')->group(function(){
    Route::resource([AuthController::class, 'signin'];
});

*/
