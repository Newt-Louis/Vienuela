<?php

namespace App\Models\CardFunctionModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey='id_task';

    public function be_longs_to_one_checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class,'id_checklist');
    }
}
