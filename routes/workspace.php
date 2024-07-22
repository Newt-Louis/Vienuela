<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkspaceController;

Route::prefix('workspace')->group(function () {
    Route::get('/owned/{id}', [WorkspaceController::class,'get_workspaces_owned']);
    Route::get('/joined/{id}', [WorkspaceController::class,'get_workspaces_joined']);
    Route::post('/add',[WorkspaceController::class,'create_workspace']);
    Route::post('/update',[WorkspaceController::class,'update_workspace']);
    Route::post('/soft_delete',[WorkspaceController::class,'soft_delete_workspace']);
    Route::get('/board_owned/{id}',[WorkspaceController::class,'get_boards_belongsTo_workspace_user_owned']);
});
