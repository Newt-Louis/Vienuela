<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workspace extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_workspace';
    public function has_many_boards(): HasMany
    {
        return $this->hasMany(Board::class,'id_workspace');
    }
    public function belongs_to_many_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,
            'users_workspaces','id_workspace','id_user')
            ->withPivot('id_role','created_at','updated_at','deleted_at');
    }
    protected static function booted() : void
    {
        static::deleting(function ($workspace){
            $workspace->has_many_boards()->delete();
            foreach ($workspace->belongs_to_many_users as $user){
                $workspace->belongs_to_many_users()
                    ->updateExistingPivot($user->id_user,['deleted_at'=>now()]);
            }
        });
    }
}
