<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardFunctionController\AttachmentController;

Route::prefix('/upload')->group(function () {
    Route::get('/view/{id}', [AttachmentController::class, 'view_all_files_in_this_card']);
    Route::post('/create_or_update/{id}',[AttachmentController::class,'create_or_update_attachment_this_card']);
    Route::post('/soft_delete',[AttachmentController::class,'soft_delete_attachment_this_card']);
});
