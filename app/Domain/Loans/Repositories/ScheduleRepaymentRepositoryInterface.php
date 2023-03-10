<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\DataTransferObjects\ScheduleRepaymentData;

interface ScheduleRepaymentRepositoryInterface
{
    public function store(ScheduleRepaymentData $scheduleRepaymentData): ScheduleRepaymentData;
    public function bulkStore(array $scheduleRepayments): void;
    public function update(ScheduleRepaymentData $scheduleRepaymentData, $scheduleRepaymentId): ScheduleRepaymentData;
}
