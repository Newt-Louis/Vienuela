<?php

namespace App\Models\CardFunctionModels;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;



/**
 * @property int $id_card
 * @property string $start_date
 * @property string $due_date
 * @property string $warning
 * @property string $danger
 */
class DateDeadline extends Model
{
    use SoftDeletes;
    protected $primaryKey='id_card';
    protected $fillable = [
        'id_card',
        'start_date',
        'due_date',
        'warning',
        'danger',
    ];
    public function belongs_to_one_card(): BelongsTo
    {
        return $this->belongsTo(Card::class,'id_card');
    }
}
