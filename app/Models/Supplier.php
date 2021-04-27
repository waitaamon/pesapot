<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\{HasMany};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, Builder, SoftDeletes};

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = ['name', 'status'];

    public function payments(): HasMany
    {
        return $this->hasMany(CashPayment::class);
    }

    public function activeReceipts(): HasMany
    {
        return $this->payments()->where('status', 'active')->orWhere('status', 'transferred');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}
