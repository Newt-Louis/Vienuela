<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListOfCardController;

Route::prefix('/list')->group(function (){
    Route::get('/view/{id}',[ListOfCardController::class,'get_lists_belongs_board']);
    Route::post('/add_list',[ListOfCardController::class,'add_new_list_to_this_board']);
    Route::post('/update_title',[ListOfCardController::class,'rename_list_by_id']);
    Route::post('/delete/{id}', [ListOfCardController::class, 'soft_delete_this_list_by_id']);
    Route::post('/moved_in_board',[ListOfCardController::class,'update_position_list_inBoard']);
});
