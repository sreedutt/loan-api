<?php

namespace Domain\Loans\Models;

use App\Helpers\HasFactory;
use Domain\Customers\Models\Customer;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Enums\RepaymentFrequency;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    use HasUuids;

    public const INTEREST_RATE =  10;

    protected $fillable = [
        'customer_id',
        'repayment_term',
        'repayment_frequency',
        'amount',
        'interest_rate',
        'status',
    ];

    protected $casts = [
        'status' => LoanStatus::class,
        'repayment_frequency' => RepaymentFrequency::class,
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function isPending(): bool
    {
        return $this->status === LoanStatus::PENDING;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function approver()
    {
        return $this->belongsTo(Customer::class, 'approved_by');
    }

    public function scheduleRepayments()
    {
        return $this->hasMany(ScheduleRepayment::class, 'loan_id');
    }
}
