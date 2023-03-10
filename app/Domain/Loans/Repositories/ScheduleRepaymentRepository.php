<?php

namespace Domain\Loans\Repositories;

use Carbon\Carbon;
use Domain\Loans\DataTransferObjects\RepaymentData;
use Domain\Loans\DataTransferObjects\ScheduleRepaymentData;
use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleRepaymentRepository implements ScheduleRepaymentRepositoryInterface
{
    public function store(ScheduleRepaymentData $scheduleRepaymentData): ScheduleRepaymentData
    {
        $scheduleRepayment = new ScheduleRepayment();
        $scheduleRepayment->loan_id = $scheduleRepaymentData->loanId;
        $scheduleRepayment->amount_to_be_paid = $scheduleRepaymentData->amountToBePaid;
        $scheduleRepayment->repayment_date = $scheduleRepaymentData->repaymentDate->toDate();
        $scheduleRepayment->status = $scheduleRepaymentData->status;
        $scheduleRepayment->save();

        return ScheduleRepaymentData::fromModel($scheduleRepayment);
    }

    public function bulkStore(array $scheduleRepayments): void
    {
       ScheduleRepayment::insert($scheduleRepayments);
        
    }

    public function update(ScheduleRepaymentData $scheduleRepaymentData, $scheduleRepaymentId): ScheduleRepaymentData
    {
        $scheduleRepayment = ScheduleRepayment::find($scheduleRepaymentId);
        $scheduleRepayment->loan_id = $scheduleRepaymentData->loanId;
        $scheduleRepayment->amount_to_be_paid = $scheduleRepaymentData->amountToBePaid;
        $scheduleRepayment->repayment_date = $scheduleRepaymentData->repaymentDate->toDate();
        $scheduleRepayment->status = $scheduleRepaymentData->status;
        $scheduleRepayment->save();

        return ScheduleRepaymentData::fromModel($scheduleRepayment);
    }

    public function repayment(RepaymentData $repaymentData): ScheduleRepaymentData
    {
        $scheduleRepayment = ScheduleRepayment::find($repaymentData->scheduleRepaymentId);
        $scheduleRepayment->status = "PAID";
        $scheduleRepayment->paid_date = Carbon::now();
        $scheduleRepayment->save();


        return ScheduleRepaymentData::fromModel($scheduleRepayment);
    }
}
