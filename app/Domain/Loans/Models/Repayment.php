<?php

namespace Domain\Loans\Models;

use App\Helpers\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repayment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'amount_paid',
        'paid_date',
    ];

    protected $casts = [
        'paid_date' => 'date',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }
}
