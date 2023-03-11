<?php

namespace Domain\Loans\Repositories;

use Carbon\Carbon;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Models\Loan;

class LoanRepository implements LoanRepositoryInterface
{
    public function findByUUID($uuid): Loan
    {
        return Loan::where('uuid', $uuid)->first();
    }

    public function store(array $requestLoan): Loan
    {
        return Loan::create($requestLoan);
    }

    public function approve(int $loanId, int $approverId): Loan
    {
        $loan = Loan::find($loanId);
        $loan->status = LoanStatus::APPROVED;
        $loan->approved_at = Carbon::now();
        $loan->approved_by = $approverId;
        $loan->save();

        return $loan;
    }
}
