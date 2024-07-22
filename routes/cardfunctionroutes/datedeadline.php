<?php
use App\Http\Controllers\CardFunctionController\DateDeadlineController;
use Illuminate\Support\Facades\Route;

Route::prefix('/deadline')->group(function (){
   Route::post('/view/{id}',[DateDeadlineController::class,'fetch_deadline_this_card']);
   Route::post('/create_or_update',[DateDeadlineController::class,'create_or_update_deadline_this_card']);
   Route::post('/create_or_update_warning',[DateDeadlineController::class,'create_or_update_warning_info']);
   Route::post('/create_or_update_danger',[DateDeadlineController::class,'create_or_update_danger_info']);
   Route::post('update_is_this_card_duedate_done',[DateDeadlineController::class,'check_duedate_for_this_card_done']);
});
