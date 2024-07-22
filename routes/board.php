<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;

Route::prefix('/board')->group(function (){
    Route::get('/view/{id}',[BoardController::class, 'get_boards']);
    Route::get('/view_board_by_workspace/{idworkspace}',[BoardController::class,'get_boards_by_workspace']);
    Route::post('/create_board', [BoardController::class,'create_board']);
});
