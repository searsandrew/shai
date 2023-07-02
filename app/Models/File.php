<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['user_id', 'name', 'file_path', 'type', 'status'];

    protected static function booted()
    {
        static::addGlobalScope('uploads', function (Builder $builder) {
            $builder->where('type', 'upload');
        });
    }

    public function campaign() : BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    static function attachment(string $campaign)
    {
        return $this->where([
            'campaign_id' => $campaign,
            'type' => 'attachment',
        ])->first();
    }

}
