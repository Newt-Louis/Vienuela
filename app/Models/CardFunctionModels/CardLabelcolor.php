<?php

namespace App\Models\CardFunctionModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * @property int id_card
 * @property int id_color
 * @property string short_title
 */
class CardLabelcolor extends Pivot
{
    use SoftDeletes;

    protected $table = 'card_labelcolors';
}
