<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Kodeine\Metable\Metable;

class Campaign extends Model
{
    use HasUlids, HasFactory, Metable;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->slug = Str::slug($model->name, '-');
        });
    }

    public $defaultMetaValues = [
        'toggle_image' => false,
        'toggle_family' => false,
        'toggle_privacy' => false,
    ];

    protected function startedAt() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value),
            set: fn ($value) => Carbon::parse($value)->toDateString(),
        );
    }

    protected function endedAt() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value),
            set: fn ($value) => Carbon::parse($value)->toDateString(),
        );
    }

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
