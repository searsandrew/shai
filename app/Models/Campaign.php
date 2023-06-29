<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Kodeine\Metable\Metable;

class Campaign extends Model
{
    use HasUlids, HasFactory, Metable;
    
    public $defaultMetaValues = [
        'toggle_image' => false,
        'toggle_family' => false,
        'toggle_privacy' => false,
        'email' => 'donotreply@shai.gift',
    ];

    protected $appends = ['active'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->slug = Str::slug($model->name, '-');
        });
    }

    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    public function getActiveAttribute()
    {
        $today = Carbon::now();
        if($today->isAfter($this->started_at) && $today->isBefore($this->ended_at))
        {
            return true;
        }

        return false;
    }

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

    public function files() : HasMany
    { 
        return $this->hasMany(File::class);
    }

    public function groups() : HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function recipients() : HasMany
    {
        return $this->hasMany(Recipient::class);
    }
}
