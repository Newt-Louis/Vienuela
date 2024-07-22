<?php

namespace App\Http\Controllers\CardFunctionController;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardFunctionModels\CardLabelcolor;
use App\Models\CardFunctionModels\Labelcolor;
use Illuminate\Http\Request;

class LabelColorController extends Controller
{
    public function get_labels()
    {
        $labels = Labelcolor::all();
        return response()->json($labels);
    }
    public function get_labels_belongs_to_card($idCard)
    {
        $card = Card::find($idCard);
        $labelsBelongToCard = $card->belongs_to_card_labelcolors()
        ->whereNull('card_labelcolors.deleted_at')->get();
        return response()->json($labelsBelongToCard);
    }
    public function add_labels_into_defineCard(Request $request)
    {
        $validate = $request->validate(
            [
                'idLabelColor' => 'required',
            ],
            [
                'idLabelColor.required' => 'Chọn màu bên dưới',
            ]
        );
        if ($validate){
            $addLabel = new CardLabelcolor;
            $addLabel->id_card = $request->idCard;
            $addLabel->id_color = $request->idLabelColor;
            $addLabel->short_title = $request->shortTitle;
            $addLabel->save();
            return $this->get_labels_belongs_to_card($request->idCard);
        }
        return [
            'success' => false,
            'message' => 'Không thêm được nhãn dán',
        ];
    }
    public function update_title_label_of_this_card(Request $request)
    {
        CardLabelcolor::where('id_card', $request->idCard)
            ->where('id_color', $request->idColor)
            ->update(['short_title' => $request->titleLabelUpdate]);
        return $this->get_labels_belongs_to_card($request->idCard);
    }
    public function softDelete_a_label_in_this_card(Request $request)
    {
        CardLabelcolor::where('id_card', $request->idCard)
            ->where('id_color', $request->idColor)
            ->delete();
        return $this->get_labels_belongs_to_card($request->idCard);
    }
}
