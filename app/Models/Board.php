<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    protected $primaryKey='id_board';

    public function has_many_lists(): HasMany
    {
        return $this->hasMany(ListOfCard::class,'id_board');
    }
    public function belongs_to_many_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,
            'users_boards',
            'id_user','id_board');
    }
    public function belongs_to_background_colors(): BelongsTo
    {
        return $this->belongsTo(BackgroundColor::class,'id_bgcolor');
    }
    public static function booted() : void
    {
        static::deleting(function ($board){
            $board->has_many_lists()->delete();
            foreach($board->belong_to_many_users as $user){
                $board->belong_to_many_users()
                    ->updateExistingPivot($user->id_user,['deleted_at'=>now()]);
            }
        });
    }
}
