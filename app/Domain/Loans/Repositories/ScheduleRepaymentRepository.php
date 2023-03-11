<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\Models\Loan;
use Domain\Loans\Models\Repayment;
use Domain\Loans\Enums\RepaymentStatus;
use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepaymentRepository implements ScheduleRepaymentRepositoryInterface
{
    public function bulkStore(array $scheduleRepayments): void
    {
        ScheduleRepayment::insert($scheduleRepayments);
    }



    public function findByUuid(string $uuid): ScheduleRepayment
    {
        return ScheduleRepayment::where('uuid', $uuid)->first();
    }

    public function markPaid(int $scheduleRepaymentId): void
    {
        ScheduleRepayment::where('id', $scheduleRepaymentId)->update([
            'status' => RepaymentStatus::PAID,
        ]);

    }

    public function updateAmount(int $id, float $amount): void
    {
        ScheduleRepayment::where('id', $id)->update([
            'amount_to_be_paid' => $amount,
        ]);
    }

    public function getPendingRepaymentsByLoanId(int $loanId): Collection
    {
        return ScheduleRepayment::where('loan_id', $loanId)
            ->where('status', RepaymentStatus::PENDING)
            ->get();
    }
}
