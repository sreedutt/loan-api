<?php

namespace Domain\Loans\Repositories;

use Carbon\Carbon;
use Domain\Loans\Models\Repayment;

class RepaymentRepository implements RepaymentRepositoryInterface
{
    public function recordRepayment(float $amount, int $customerId, int $loanId): Repayment
    {
        $repayment = new Repayment();
        $repayment->amount_paid = $amount;
        $repayment->loan_id = $loanId;
        $repayment->customer_id = $customerId;
        $repayment->paid_date = Carbon::now();
        $repayment->save();

        return $repayment;
    }
}
