<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersBoard extends Model
{
    use SoftDeletes;

    public function belong_to_roles_inverse(): BelongsTo
    {
        return $this->belongsTo(Role::class,'id_role');
    }
}
