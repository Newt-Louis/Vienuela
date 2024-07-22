<?php

namespace App\Http\Controllers;

use App\Models\ListOfCard;
use App\Models\Card;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    /*CardController dùng để CRUD card và move cho card này, ngoài ra thì phần description của card cũng
    đặt ở đây vì nó không quá nhiều + cần thiết để tách ra.*/
    public function get_cards_view_in_list($idList)
    {
        $cards = Card::where('id_list',$idList)
        ->select(['id_card','id_list','title_card','position_card'])
        ->orderBy('position_card')
        ->get();
        return response()->json($cards);
    }
    public function get_cards_details_in_card($idCard){
        $infoCardDetails = Card::find($idCard);
        return response()->json($infoCardDetails);
    }
    public function add_a_card_in_list(Request $request)
    {
        $validated = $request->validate(
            [
                'titleCard' => 'required'
            ],
            [
                'titleCard' => ' Tiêu đề không được rỗng'
            ],
        );
        if ($validated){
            $added = new Card;
            $added->title_card = $request->titleCard;
            $added->id_list = $request->idList;
            $added->save();
            return $this->get_cards_view_in_list($request->idList);
        }
        return ['success' => false, 'message' => 'Không thể tạo được thẻ mới'];
    }
    public function rename_title_this_card(Request $request)
    {
        $validated = $request->validate(
            [
                'titleCard' => 'required',
            ],
            [
                'titleCard.required' => 'Tiêu đề không được rỗng',
            ],
        );
        if ($validated){
            $updateNewTitleCard = Card::find($request->idCard);
            $updateNewTitleCard->title_card = $request->titleCard;
            $updateNewTitleCard->save();
            $getIdListToFetch = $updateNewTitleCard->id_list;
            return $this->get_cards_view_in_list($getIdListToFetch);
        }
        return ['success' => false, 'message' => 'Không cập nhật được thẻ'];
    }
    public function soft_delete_this_card_by_id($idCard)
    {
        try {
            $cardDeleted = Card::find($idCard);
            $cardDeleted->delete();
            $getIdListToFetch = $cardDeleted->id_list;
            $titleListOfCardDeleted = ListOfCard::find($getIdListToFetch);
            return [
                'success' => true,
                'message' => 'Đã xóa thẻ trong danh sách: '.$titleListOfCardDeleted->title_list,
                'result' => $this->get_cards_view_in_list($getIdListToFetch)
                ];
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thẻ tương ứng',
            ], 404);
        }
    }
    public function fetch_description_this_card($idCard)
    {
        $description = Card::find($idCard);
        return response()->json($description->description);
    }
    public function update_or_create_description_this_card(Request $request)
    {
        $card = Card::find($request->idCard);
        $card->description = $request->descriptionText;
        $card->save();
        return response()->json($card);
    }
    public function update_position_card_inList(Request $request)
    {
        $dataToMoved = $request->all();
        $this->update_position_card_in_database($dataToMoved);
        return response()->json();
    }
    public function update_position_card_in_database($data){
        foreach ($data as $itemCard){
            $cardInstance = Card::find($itemCard['idCard']);
            if ($cardInstance){
                $cardInstance->position_card = $itemCard['positionCard'];
                $cardInstance->save();
            }
        }
    }
    public function update_position_card_change_list(Request $request)
    {
       $array1 = $request->newList;
        if ($request->has('oldList')){
            $array2 = $request->oldList;
            $this->update_position_card_in_database($array2);
        }
        $this->update_position_card_in_database($array1);
        $cardInstanceChangeIdList = Card::find($request->instanceCardUpdated['idCard']);
        $cardInstanceChangeIdList->id_list = $request->instanceCardUpdated['idList'];
        $cardInstanceChangeIdList->save();
        return response()->json();
    }
}
