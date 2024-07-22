<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BackgroundColor extends Model
{

    protected $primaryKey='id_bgcolor';

    public function bgcolor_has_many_boards(): HasMany
    {
        return $this->hasMany(Board::class);
    }
}
