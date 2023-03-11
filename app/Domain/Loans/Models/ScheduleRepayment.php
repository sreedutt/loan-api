<?php

namespace Domain\Loans\Models;

use App\Helpers\HasFactory;
use Domain\Loans\Enums\RepaymentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ScheduleRepayment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'amount_to_be_paid',
        'repayment_date',
        'status',
    ];

    protected $casts = [
        'status' => RepaymentStatus::class,
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }
}
