<?php

namespace App\Models\CardFunctionModels;

use App\Models\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Labelcolor extends Model
{
    protected $primaryKey='id_color';

    public function belongs_to_card_labelcolors(): BelongsToMany
    {
        return $this->belongsToMany(Card::class,
            'card_labelcolors','id_color','id_card');
    }
}
