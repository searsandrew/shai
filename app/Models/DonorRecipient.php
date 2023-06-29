<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class DonorRecipient extends Model
{
    use HasFactory;

    protected $table = 'donor_recipient';
    protected $fillable = ['status'];

    public function communications() : HasMany
    {
        return $this->hasMany(Communication::class);
    }

    public function donor() : BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function recipient() : BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }
}
