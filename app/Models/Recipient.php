<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipient extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['external_id', 'name', 'privacy'];

    public function campaign() : BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
