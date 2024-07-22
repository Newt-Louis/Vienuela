<?php

namespace App\Models;

use App\Models\CardFunctionModels\Attachment;
use App\Models\CardFunctionModels\Checklist;
use App\Models\CardFunctionModels\DateDeadline;
use App\Models\CardFunctionModels\Labelcolor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;


    protected $primaryKey='id_card';

    public function belongs_to_card_labelcolors(): Relation
    {
        return $this->belongsToMany(Labelcolor::class,
            'card_labelcolors',
            'id_card','id_color')
            ->withPivot('short_title','created_at','updated_at','deleted_at');
    }

    public function belongs_to_attachment_cards(): Relation {
        return $this->belongsToMany(Attachment::class,
            'attachment_cards',
            'id_card','id_attachment')
            ->withPivot('created_at','updated_at','deleted_at');
    }
    public function belongs_to_many_users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,
            'users_cards','id_card','id_user');
    }
    public function has_many_checklists(): HasMany
    {
        return $this->hasMany(Checklist::class,'id_card');
    }
    public function has_one_date_deadlines(): HasOne
    {
        return $this->hasOne(DateDeadline::class,'id_card');
    }
    protected static function booted() : void
    {
        static::deleting(function ($card){
            foreach ($card->belongs_to_card_labelcolors as $label){
                $card->belongs_to_card_labelcolors()
                    ->updateExistingPivot($label->id_color,['deleted_at'=>now()]);
            };
            foreach ($card->belongs_to_attachment_cards as $attachment){
                $card->belongs_to_attachment_cards()
                    ->updateExistingPivot($attachment->id_attachment,['deleted_at'=>now()]);
            };
            $card->has_many_checklists()->delete();
            $card->has_one_date_deadlines()->delete();
        });
    }
}
