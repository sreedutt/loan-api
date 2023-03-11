<?php

namespace Domain\Loans\Repositories;

use Carbon\Carbon;
use Domain\Loans\Models\Loan;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Enums\RepaymentStatus;
use Illuminate\Validation\Rules\In;

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

    public function checkForPendingRepayment(int $loanId): bool
    {
        return Loan::whereHas('scheduleRepayments', function ($query) {
            $query->where('status', RepaymentStatus::PENDING);
        })->exists();
    }

    public function markPaid(int $loanId): void 
    {
        Loan::where('id', $loanId)->update([
            'status' => LoanStatus::PAID,
        ]);

    }
}
