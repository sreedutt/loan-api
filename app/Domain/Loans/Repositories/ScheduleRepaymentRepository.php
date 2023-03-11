<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\Models\ScheduleRepayment;

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
}
