<?php

namespace App\Models;

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

    protected $fillable = ['name'];

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
