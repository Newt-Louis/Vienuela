<?php

namespace App\Http\Controllers\CardFunctionController;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardFunctionModels\DateDeadline;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DateDeadlineController extends Controller
{
    public function fetch_deadline_this_card($idCard)
    {
        $deadlineView = DateDeadline::find($idCard);
        return response()->json($deadlineView);
    }
    public function create_or_update_deadline_this_card(Request $request)
    {
        $validated = $request->validate(
            [
                'idCard' => 'required',
                'startDate' => [

                    function ($attribute, $value, $fail) {
                        if ($value === null || $value === ''){
                            return;
                        }
                    $date = Carbon::createFromFormat('d-m-Y H:i', $value);
                        if (!$date){
                            $fail('Ngày bắt đầu phải là một ngày hợp lệ !');
                        }
                    }
                ],
                'dueDate' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value === null || $value === ''){
                            return;
                        }
                        $startDate = Carbon::createFromFormat('d-m-Y H:i', $request->input('startDate'));
                        $dueDate = Carbon::createFromFormat('d-m-Y H:i', $value);
                        if (!$dueDate) {
                            $fail('Ngày đến hạn phải là một ngày hợp lệ.');
                        } elseif ($dueDate->lte($startDate)) {
                            $fail('Ngày đến hạn phải lớn hơn thời gian bắt đầu.');
                        }
                    },
                    ],
            ],
            [
                'idCard.required' => 'Có lỗi không xác định với mã thẻ !!!',
            ]
        );
        if ($validated){
            $deadlineAdded = DateDeadline::updateOrCreate(
                [
                'id_card' => $request->idCard,
                ],
                [
                    'start_date' => $request->startDate ? Carbon::createFromFormat('d-m-Y H:i', $request->startDate)->toDateTimeString() : null,
                    'due_date' => $request->dueDate ? Carbon::createFromFormat('d-m-Y H:i', $request->dueDate)->toDateTimeString() : null,
                ]
            );
            return $this->fetch_deadline_this_card($request->idCard);
        }
        return ['success' => false, 'message' => 'Lỗi kết nối máy chủ, vui lòng thử lại !'];
    }
    public function create_or_update_warning_info(Request $request)
    {
        $deadlineAdded = DateDeadline::find($request->idCard);
        if ($deadlineAdded === null){
            return response()->json(['success'=>false,'message' => 'Vui lòng cập nhật thời gian đáo hạn !!!'],400);
        }
        $deadlineAdded->warning = $request->warningInfo;
        $deadlineAdded->save();
        return $this->fetch_deadline_this_card($request->idCard);
    }
    public function create_or_update_danger_info(Request $request)
    {
        $deadlineAdded = DateDeadline::find($request->idCard);
        if ($deadlineAdded === null){
            return response()->json(['success'=>false,'message' => 'Vui lòng cập nhật thời gian đáo hạn !!!'],400);
        }
        $deadlineAdded->danger = $request->dangerInfo;
        $deadlineAdded->save();
        return $this->fetch_deadline_this_card($request->idCard);
    }
    public function check_duedate_for_this_card_done(Request $request)
    {
        $deadlineAdded = DateDeadline::find($request->idCard);
        if ($deadlineAdded === null){
            return response()->json(['success'=>false,'message' => 'Không thể đánh dấu Hoàn Thành khi chưa có thời gian đáo hạn !!!'],400);
        }
        $deadlineAdded->is_duedate_done = $request->isDueDateDone;
        $deadlineAdded->save();
        return $this->fetch_deadline_this_card($request->idCard);
    }
}
