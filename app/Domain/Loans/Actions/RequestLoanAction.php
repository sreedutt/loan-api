<?php

namespace Domain\Loans\Actions;

use Domain\Loans\Models\Loan;
use Domain\Loans\Repositories\LoanRepositoryInterface;

class RequestLoanAction
{
    public function __construct(public LoanRepositoryInterface $repository)
    {
    }

    public function execute(array $requestLoan): Loan
    {
        return $this->repository->store($requestLoan);
    }
}
