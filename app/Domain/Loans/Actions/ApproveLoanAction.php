<?php

namespace Domain\Loans\Actions;

use Domain\Loans\Events\LoanApprovedEvent;
use Domain\Loans\Models\Loan;
use Domain\Loans\Repositories\LoanRepositoryInterface;

class ApproveLoanAction
{
    public $repository;

    public function __construct(LoanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute($loanId, $approverId): Loan
    {
        $loan = $this->repository->approve($loanId, $approverId);

        LoanApprovedEvent::dispatch($loan);

        return $loan;
    }
}
