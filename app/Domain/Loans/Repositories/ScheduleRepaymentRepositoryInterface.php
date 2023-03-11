<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleRepaymentRepositoryInterface
{
    public function bulkStore(array $scheduleRepayments): void;
    public function findByUuid(string $uuid): ScheduleRepayment;
    public function markPaid(int $scheduleRepaymentId): void;
    public function updateAmount(int $id, float $amount): void;
    public function getPendingRepaymentsByLoanId(int $loanId): Collection;
}
