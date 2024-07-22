<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
//  function get_workspaces_owned($idUser) lấy tất cả workspace mà người dùng hiện tại là owned
    public function get_workspaces_owned($idUser)
    {
        $workspaces = User::find($idUser)->has_many_workspaces;
        return response()->json($workspaces);
    }
//    function get_workspaces_joined($idUser) lấy tất cả workspace mà người dùng hiện tại tham gia
    public function get_workspaces_joined($idUser)
    {
        $workspaces = User::find($idUser)->belongs_to_many_workspaces;
        return response()->json($workspaces);
    }
    /*Vì đang ở trang là workspace nên khi render board là phải dựa vào workspace ở đây để hiển thị
    các board có trong workspace này.*/
    public function get_boards_belongsTo_workspace_user_owned($idUser)
    {
        // lấy toàn bộ dữ liệu workspace, board, bgcolor của board
        $workspaces = User::find($idUser)->has_many_workspaces()
        ->join('boards','boards.id_workspace','=','workspaces.id_workspace')
        ->join('background_colors','boards.id_bgcolor','=','background_colors.id_bgcolor')
        ->select('*')->get();
        // lấy danh sách các board thuộc về người dùng
        return response()->json($workspaces);
    }
    public function get_boards_belongsTo_workspace_user_joined($idUser)
    {

    }
//    ---------------Tạo workspace----------------
    public function create_workspace(Request $request)
    {
        $validated = $request->validate(
            [
            'workspaceTitle' => 'required |max:25',
        ],
        [
            'workspaceTitle.required' => 'Chưa nhập tiêu đề cho không gian làm việc',
            'workspaceTitle.max' => 'Tối đã chỉ được 25 ký tự',
        ]
        );
        if ($validated) {
            $workspace = new Workspace;
            $workspace->title_workspace = $request->workspaceTitle;
            $workspace->id_user = $request->idUser;
            $workspace->save();
            return $this->get_workspaces_owned($request->idUser);
        }
        return response()->json();
    }
//    ---------------------------------------Update workspace---------------------------------------
    public function update_workspace(Request $request)
    {
        $validated = $request->validate(
            [
                'workspaceTitle' => 'required',
            ],
            [
                'workspaceTitle.required' => 'Chưa nhập tiêu đề cần thay đổi',
            ]
        );
        if ($validated){
            $dataWorkSpace = Workspace::find($request->workspaceID);
            $dataWorkSpace->title_workspace = $request->workspaceTitle;
            $dataWorkSpace->save();
            return $this->get_workspaces_owned($request->idUser);
        }
        return response()->json();
    }
//    ----------------------------------Xóa bằng softDeletes() workspace-------------------------------------
    public function soft_delete_workspace(Request $request)
    {
        $workspace = Workspace::where('id_user',$request->idUser)
                              ->where('id_workspace',$request->idWorkSpace)
                              ->first();
        if ($workspace){
            $workspace->delete();
            return $this->get_workspaces_owned($request->idUser);
        } else {
            return response()->json();
        }
    }
}
