<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Donor extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['name', 'email'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $private = Str::random(48);
            $model->private_key = Crypt::encryptString($private);
            $model->public_key = Crypt::encryptString(Hash::make($private . config('app.salt')));
        });
    }

    public function communications() : HasMany
    {
        return $this->hasMany(Communication::class);
    }

    public function recipients() : BelongsToMany
    {
        return $this->belongsToMany(Recipient::class)->withPivot('status')->withTimestamps();
    }

    public function groups(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Recipient::class, Group::class);
    }
}
