<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class BoardController extends Controller
{
//    function get_boards($idUser) lấy thông tin 1 board và chuyển dữ liệu cho trang BoardLayout
    public function get_boards($idBoard)
    {
        $boards = Board::where('id_board',$idBoard)
        ->join('background_colors','boards.id_bgcolor','=','background_colors.id_bgcolor')
        ->select('*')->get();
        return response()->json($boards);
    }
    public function get_boards_by_workspace($idWorkSpace){
        $boards = Workspace::find($idWorkSpace)->has_many_boards()
        ->with('belongs_to_background_colors')
        ->get();
        return response()->json($boards);
    }
//    function create_board(Request $request) tạo bảng mới tại header
    public function create_board(Request $request)
    {
        $validated = $request->validate(
            [
              'title_board' => 'required | max: 25',
                'id_workspace' => 'required',
            ],
            [
                'title_board.required' => 'Chưa nhập tiêu đề cho bảng',
                'title_board.max' => 'Tối đa 25 ký tự',
                'id_workspace.required' => 'Chưa chọn không gian cho bảng',
            ]
        );
        if ($validated) {
            $board = new Board;
            $board->title_board = $request['title_board'];
            $board->id_workspace = $request['id_workspace'];
            $board->id_bgcolor = $request['id_bgcolor'];
            $board->save();
            return $this->get_boards_by_workspace($request->id_workspace);
        }
        return ['success' => false, 'message' => 'Tạo thất bại. Vui lòng thử lại !'];
    }
}
