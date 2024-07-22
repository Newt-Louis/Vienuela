<?php

namespace App\Http\Controllers\CardFunctionController;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardFunctionModels\Attachment;
use App\Models\CardFunctionModels\AttachmentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{

    public function view_all_files_in_this_card($idCard) {
        $attachmentList = AttachmentCard::where('id_card', $idCard)
            ->join('attachments','attachment_cards.id_attachment','=','attachments.id_attachment')
            ->select('*')->get();
        return response()->json($attachmentList);
    }
    public function create_or_update_attachment_this_card(Request $request,$idCard)
    {
        $file = $request->file('file');
        $mimeType = $file->getMimeType();

        if (str_contains($mimeType, 'image')){
            $path = $file->store('imgs','public');
        } else {
            $path = $file->store('anotherfiles','public');
        }
        $attachmentAdded = new Attachment;
        $attachmentAdded->attachment_name = $file->getClientOriginalName();
        $attachmentAdded->attachment_path = $path;
        $attachmentAdded->save();
//        Tìm card với idCard được gửi bởi url
        $card = Card::find($idCard);
//        Sử dụng relationship của eloquent và phương thức attach để thêm liên kết mỗi khi attachment được thêm vào card này.
        $card->belongs_to_attachment_cards()->attach($attachmentAdded->id_attachment);
        return $this->view_all_files_in_this_card($idCard);
    }
    public function soft_delete_attachment_this_card(Request $request)
    {
        AttachmentCard::where('id_card',$request->idCard)
            ->where('id_attachment',$request->idAttachment)
            ->delete();
        return $this->view_all_files_in_this_card($request->idCard);
    }
}
