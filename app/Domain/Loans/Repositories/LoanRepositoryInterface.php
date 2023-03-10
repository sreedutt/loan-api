<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\Models\Loan;

interface LoanRepositoryInterface
{
    public function findByUUID(int $uuid): Loan;
    public function approve(int $loanId, int $approverId): Loan;
}
