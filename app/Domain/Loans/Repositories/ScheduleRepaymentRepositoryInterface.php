<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\Models\ScheduleRepayment;
use Domain\Loans\DataTransferObjects\ScheduleRepaymentData;

interface ScheduleRepaymentRepositoryInterface
{
    public function bulkStore(array $scheduleRepayments): void;
    public function findByUuid(string $uuid): ScheduleRepayment;
}
