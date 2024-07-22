<?php

use App\Http\Controllers\CardFunctionController\LabelColorController;
use Illuminate\Support\Facades\Route;

Route::prefix('/label')->group(function (){
    Route::get('/view', [LabelColorController::class,'get_labels']);
    Route::post('/label_belongs_this_card/{id}', [LabelColorController::class,'get_labels_belongs_to_card']);
    Route::post('/add',[LabelColorController::class,'add_labels_into_defineCard']);
    Route::post('/update_title',[LabelColorController::class,'update_title_label_of_this_card']);
    Route::post('/soft_delete',[LabelColorController::class,'softDelete_a_label_in_this_card']);
});
