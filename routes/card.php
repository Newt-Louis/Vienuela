<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
Route::prefix('/card')->group(function (){
   Route::get('/view/{id}', [CardController::class,'get_cards_view_in_list']);
   Route::get('/details/{id}', [CardController::class,'get_cards_details_in_card']);
   Route::post('/add', [CardController::class,'add_a_card_in_list']);
   Route::post('/update_title_card', [CardController::class, 'rename_title_this_card']);
   Route::post('/soft_delete/{id}', [CardController::class, 'soft_delete_this_card_by_id']);
   Route::get('/description_fetch/{id}', [CardController::class, 'fetch_description_this_card']);
   Route::post('/update_description', [CardController::class,'update_or_create_description_this_card']);
   Route::post('/moved_in_list',[CardController::class,'update_position_card_inList']);
   Route::post('/moved_change_list',[CardController::class,'update_position_card_change_list']);
});
