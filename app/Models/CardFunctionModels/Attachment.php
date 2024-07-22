<?php

namespace App\Models\CardFunctionModels;

use App\Models\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attachment extends Model
{
    protected $primaryKey='id_attachment';

    public function belongs_to_attachment_cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class,
            'attachment_cards','id_attachment','id_card');
    }
}
