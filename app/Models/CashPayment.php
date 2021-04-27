<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class CashPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['supplier_id', 'user_id', 'amount', 'status', 'date', 'note'];

    protected $dates = ['date'];

    const STATUSES = [
        'active' => 'Active',
        'transferred' => 'Transferred',
        'reversed' => 'Reversed',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
