<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardFunctionController\CheckListController;

Route::prefix('/checklist')->group(function (){
   Route::get('/view/{id}', [CheckListController::class,'fetch_checklist_via_task_in_this_card']);
   Route::post('/add_new_checklist',[CheckListController::class,'create_checklist_this_card']);
   Route::post('/soft_delete_checklist', [CheckListController::class,'soft_delete_a_checklist_in_this_card']);
   Route::post('/add_task',[CheckListController::class,'create_tasks_this_card']);
   Route::post('/soft_delete_task/{id}',[CheckListController::class,'soft_delete_a_task_in_this_checklist']);
   Route::post('/update_task_checked',[CheckListController::class,'update_checked_task_in_this_checklist']);
});
