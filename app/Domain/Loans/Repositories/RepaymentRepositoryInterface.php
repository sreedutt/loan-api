<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\Models\Repayment;

interface RepaymentRepositoryInterface
{
    public function recordRepayment(float $amount, int $customerId, int $loanId): Repayment;
}
