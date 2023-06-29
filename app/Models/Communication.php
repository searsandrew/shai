<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['type', 'payload'];

    public function donorRecipient() : BelongsTo
    {
        return $this->belongsTo(DonorRecipient::class);
    }
}
