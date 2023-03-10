<?php

namespace Domain\Loans\Actions;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Domain\Loans\Enums\RepaymentFrequency;
use Domain\Loans\Enums\RepaymentStatus;
use Domain\Loans\Models\Loan;
use Domain\Loans\Repositories\ScheduleRepaymentRepositoryInterface;

class CreateScheduledRepaymentsAction
{
    public const WEEKS_IN_A_YEAR = 52;
    public const MONTHS_IN_A_YEAR = 12;
    public const QUARTERS_IN_A_YEAR = 4;

    public $repository;

    public function __construct(ScheduleRepaymentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Loan $loan)
    {
        $yearlyInterest = $loan->amount * ($loan->interest_rate / 100);

        $interestCalculatedPerType = match($loan->repayment_frequency){
            RepaymentFrequency::WEEKLY => $yearlyInterest / static::WEEKS_IN_A_YEAR,
            RepaymentFrequency::MONTHLY => $yearlyInterest / static::MONTHS_IN_A_YEAR,
            RepaymentFrequency::QUARTERLY => $yearlyInterest / static::QUARTERS_IN_A_YEAR,
            RepaymentFrequency::YEARLY => $yearlyInterest,
        };
        
        
        $interestToBePaid =  $interestCalculatedPerType * $loan->repayment_term;

        $installmentToBePaid = round(($loan->amount + $interestToBePaid) / $loan->repayment_term, 2);
        
        $scheduleRepayments = [];

        $scheduledDates =  match($loan->repayment_frequency){
            RepaymentFrequency::WEEKLY => 
                CarbonInterval::days(7)->toPeriod(Carbon::now()->addDays(7), Carbon::now()->addWeeks($loan->repayment_term)),
            RepaymentFrequency::MONTHLY => 
                CarbonInterval::month(1)->toPeriod(Carbon::now()->addMonth(), Carbon::now()->addMonths($loan->repayment_term)),
            RepaymentFrequency::QUARTERLY => 
                CarbonInterval::month(4)->toPeriod(Carbon::now()->addMonths(4), Carbon::now()->addMonths(4 * $loan->repayment_term)),
            RepaymentFrequency::YEARLY => 
                CarbonInterval::year(1)->toPeriod(Carbon::now()->addYear(), Carbon::now()->addYears($loan->repayment_term)),
        };

        foreach($scheduledDates as $scheduledDate)
        {
            if ($scheduledDate->eq($scheduledDates->last())) {
                $installmentToBePaid = ($loan->amount + $interestToBePaid) - (($loan->repayment_term - 1) * $installmentToBePaid);
            }

            $scheduleRepayments[] = [
                'loan_id' => $loan->id,
                'amount_to_be_paid' => round($installmentToBePaid, 2),
                'repayment_date' => $scheduledDate->toDateString(),
                'status' => RepaymentStatus::PENDING,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->repository->bulkStore($scheduleRepayments);
    }
}
