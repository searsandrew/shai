<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['user_id', 'name', 'file_path', 'status'];

    public function campaign() : BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
