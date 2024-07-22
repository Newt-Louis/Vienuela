<?php

namespace App\Http\Controllers;

use App\Models\ListOfCard;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListOfCardController extends Controller
{
    public function get_lists_belongs_board($idBoard)
    {
        $lists = ListOfCard::where('id_board',$idBoard)
            ->orderBy('position_list')
            ->get();
        return response()->json($lists);
    }
    public function add_new_list_to_this_board(Request $request)
    {
        $validated = $request -> validate(
            [
                'titleList' => 'required'
            ],
            [
                'titleList.required' => 'Chưa nhập tiêu đề cho list',
            ]
        );
        if($validated){
            $listAdded = new ListOfCard;
            $listAdded->id_board = $request->idBoard;
            $listAdded->title_list = $request->titleList;
            $listAdded->save();
            return $this->get_lists_belongs_board($request->idBoard);
        }
        return ['success'=>false,'message'=>'Tạo mới thất bại !!!'];
    }
    public function rename_list_by_id(Request $request)
    {
        $validated = $request -> validate(
            [
                'titleList' => 'required'
            ],
            [
                'titleList.required' => 'Tiêu đề không được để trống',
            ]
        );
        if ($validated){
            $list_updated_title = ListOfCard::find($request->idList);
            $list_updated_title->title_list = $request->titleList;
            $list_updated_title->save();
            return response()->json($list_updated_title);
        }
        return ['success' => false, 'message' => 'Cập nhật thất bại, thử lại sau !!!'];
    }
    public function soft_delete_this_list_by_id($id)
    {
        try {
            $listDeleted = ListOfCard::find($id);
            $listDeleted->delete();
            return [
                'success' => true,
                'message' => 'Đã xóa danh sách: '.$listDeleted->title_list.' và các thẻ con liên quan',
                ];
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Không tìm thấy danh sách tương ứng',
                'success' => false,
            ], 404);
        }
    }
    public function update_position_list_inBoard(Request $request){
        $dataToMoved = $request->all();
        foreach ($dataToMoved as $itemInData){
            $listInstanceDatabase = ListOfCard::find($itemInData['idList']);
            if ($listInstanceDatabase){
                $listInstanceDatabase->position_list = $itemInData['positionList'];
                $listInstanceDatabase->save();
            }
        }
        return $this->get_lists_belongs_board($dataToMoved[0]['idBoard']);
    }
}
