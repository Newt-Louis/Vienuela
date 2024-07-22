<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static findOrFail($account_user)
 * @method static create(array $user)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'avatar_user',
        'avatar_path',
        'account_user',
        'name_user',
        'email_user',
        'phone_user',
        'password_user',
        'change_password_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_user',
        'password_user_confirmation',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function getAuthPassword()
    {
        return $this->password_user;
    }
    public function getAuthPasswordName()
    {
        return $this->password_user;
    }
    protected function casts(): array
    {
        return [
            'login_at' => 'datetime',
            'change_password_at' => 'datetime',
            'password_user' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
//    ------------------------Quản lý các mối quan hệ trong database---------------------------
    public function has_many_workspaces(): HasMany
    {
        return $this->hasMany(Workspace::class,'id_user');
    }
    public function belongs_to_many_workspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class,
            'users_workspaces','id_user','id_workspace');
    }
    public function belongs_to_many_boards(): BelongsToMany
    {
        return $this->belongsToMany(Board::class,
            'users_boards','id_user','id_board');
    }
    public function belongs_to_many_cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class,
            'users_cards','id_user','id_card');
    }
}
