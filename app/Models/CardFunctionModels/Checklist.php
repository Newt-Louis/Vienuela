<?php

namespace App\Models\CardFunctionModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use SoftDeletes;

    protected $primaryKey='id_checklist';

    public function has_many_tasks(): HasMany
    {
        return $this->hasMany(Task::class,'id_checklist');
    }
    protected static function booted(): void
    {
        static::deleting(function ($checklist){
            $checklist->has_many_tasks()->delete();
        });
    }
}
