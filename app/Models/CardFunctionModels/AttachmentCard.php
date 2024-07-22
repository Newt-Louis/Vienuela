<?php

namespace App\Models\CardFunctionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachmentCard extends Pivot
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'attachment_cards';
}
