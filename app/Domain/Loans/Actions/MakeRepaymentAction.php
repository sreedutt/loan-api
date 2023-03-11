<?php

namespace Domain\Loans\Actions;

use Domain\Loans\Events\RepaymentRecordedEvent;
use Domain\Loans\Models\Repayment;
use Domain\Loans\Models\ScheduleRepayment;
use Domain\Loans\Repositories\RepaymentRepositoryInterface;

class MakeRepaymentAction
{
    public function __construct(public RepaymentRepositoryInterface $repository)
    {        
    }

    public function execute(ScheduleRepayment $scheduleRepayment, float $amount, int $customerId): Repayment
    {
        $repayment =  $this->repository->recordRepayment($amount, $customerId, $scheduleRepayment->loan_id);

        RepaymentRecordedEvent::dispatch($repayment, $scheduleRepayment);

        return $repayment;
    }
}