<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Group extends Model
{
    use HasFactory, HasUlids;

    protected $appends = ['external_id'];
    protected $fillable = ['name', 'held_at'];

    protected static function booted()
    {
        // static::addGlobalScope('notHeld', function (Builder $builder) {
        //     $builder->where('held_at', NULL);
        // });
    }

    public function getExternalIdAttribute() // : int|bool
    {
        $recipients = $this->recipients()->get();
        if($recipients->count() > 0)
        {
            return $recipients->first()->external_id;
        }

        return false;
    }

    public function campaign() : BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function recipients() : HasMany
    {
        return $this->hasMany(Recipient::class);
    }

    public function donors(): BelongsToMany
    {
        return $this->recipients()->first()->donors();
    }
}
