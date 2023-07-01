<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invite extends Model
{
    use HasUlids, HasFactory, SoftDeletes;

    protected $fillable = ['organization_id', 'email'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
