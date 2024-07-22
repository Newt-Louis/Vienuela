<?php

namespace App\Http\Controllers\CardFunctionController;

use App\Http\Controllers\Controller;
use App\Models\CardFunctionModels\Checklist;
use App\Models\CardFunctionModels\Task;
use Illuminate\Http\Request;

class CheckListController extends Controller
{
    public function fetch_checklist_via_task_in_this_card($idCard)
    {
        try {
            $checklists = Checklist::where('id_card', $idCard)->get();
            $checklists->load('has_many_tasks');
            return response()->json($checklists);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi phía máy chủ, vui lòng thử lại'], 500);
        }
    }
    public function create_checklist_this_card(Request $request)
    {
        try {
            $checklistAdded = new Checklist;
            $checklistAdded->id_card = $request->idCard;
            $checklistAdded->title_checklist = $request->titleCheckList;
            $checklistAdded->save();
            return $this->fetch_checklist_via_task_in_this_card($request->idCard);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi phía máy chủ, vui lòng thử lại'], 500);
        }
    }

    public function soft_delete_a_checklist_in_this_card(Request $request)
    {
        try {
            $checklistDeleted = Checklist::find($request->idChecklist);
            $checklistDeleted->delete();
            return $this->fetch_checklist_via_task_in_this_card($request->idCard);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi phía máy chủ, vui lòng thử lại'], 500);
        }
    }

    public function create_tasks_this_card(Request $request)
    {
        $validated = $request->validate(
            [
                'titleTask' => 'required',
            ],
            [
                'titleTask.required' => 'Thiếu mô tả cho nhiệm vụ',
            ],
        );
        if ($validated){
            $taskAdded = new Task;
            $taskAdded->description = $request->titleTask;
            $taskAdded->is_checked = $request->checked;
            $taskAdded->id_checklist = $request->idChecklist;
            $taskAdded->save();
            $checklist = $taskAdded->be_longs_to_one_checklist;
            return response()->json($checklist);
        }
            return response()->json(['message' => 'Có lỗi phía máy chủ, vui lòng thử lại'], 500);
    }
    public function update_checked_task_in_this_checklist(Request $request)
    {
        $task = Task::find($request->idTask);
        $task->is_checked = $request->isChecked;
        $task->save();
        $checklist = $task->be_longs_to_one_checklist;
        return response()->json($checklist);
    }
    public function soft_delete_a_task_in_this_checklist($idTask)
    {
        $taskDeleted = Task::find($idTask);
        $getIdCheckList = $taskDeleted->id_checklist;
        $taskDeleted->delete();
        $checklistResponse = Checklist::find($getIdCheckList);
        return response()->json($checklistResponse);
    }
}
