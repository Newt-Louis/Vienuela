<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListOfCard extends Model
{
    use SoftDeletes;

    protected $primaryKey='id_list';
    public function has_many_cards(): HasMany
    {
        return $this->hasMany(Card::class,'id_list');
    }
    protected static function booted(): void
    {
        static::deleting(function ($list) {
            $list->has_many_cards()->delete();
    });
    }
}
