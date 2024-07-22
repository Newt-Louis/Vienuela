<?php
include __DIR__.'/workspace.php';
include __DIR__.'/board.php';
include __DIR__.'/lists.php';
include __DIR__.'/card.php';
include __DIR__ . '/cardfunctionroutes/label.php';
include __DIR__.'/cardfunctionroutes/datedeadline.php';
include __DIR__.'/cardfunctionroutes/upload.php';
include __DIR__.'/cardfunctionroutes/checklist.php';
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackgroundColorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/login', [UserController::class,'signIn']);
Route::post('/user/logout','App\Http\Controllers\UserController@signOut')->middleware('auth:sanctum');
Route::post('/user/register', [UserController::class, 'createUser']);
Route::get('/opencreateboard',[BackgroundColorController::class, 'get_all_backgroundcolor']);

Route::get('/get_workspace_boards/{id}', [BoardController::class,'get_boards']);

