<?php

namespace Domain\Loans\Repositories;

use Domain\Loans\Models\Loan;

interface LoanRepositoryInterface
{
    public function findByUUID(int $uuid): Loan;
    public function store(array $loan): Loan;
    public function approve(int $loanId, int $approverId): Loan;
    public function checkForPendingRepayment(int $loanId): bool;
    public function markPaid(int $loanId): void;
}
