<?php

namespace Domain\Loans\Actions;

use Domain\Loans\Models\Loan;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Models\Repayment;
use Domain\Loans\Models\ScheduleRepayment;
use Domain\Loans\Repositories\LoanRepositoryInterface;
use Domain\Loans\Repositories\ScheduleRepaymentRepositoryInterface;

class AdjustRepaymentAgainstLoanAction
{
    public function __construct(
        public ScheduleRepaymentRepositoryInterface $repository,
        public LoanRepositoryInterface $loanRepository
    ) {
    }

    public function execute(Repayment $repayment, ScheduleRepayment $scheduleRepayment): void
    {
        $loan = $repayment->loan;

        if ($repayment->amount_paid >= $scheduleRepayment->amount_to_be_paid) {
            $this->repository->markPaid($scheduleRepayment->id);
        } else {
            $this->repository->updateAmount(
                $scheduleRepayment->id,
                $scheduleRepayment->amount_to_be_paid - $repayment->amount_paid,
            );

            return;
        }

        $extraAmount = $repayment->amount_paid - $scheduleRepayment->amount_to_be_paid;

        if ($extraAmount > 0) {
            $this->adjustWithPendingScheduleRepayments($loan, $extraAmount);
        }

        $loanHasPendingRepayments = $this->loanRepository->checkForPendingRepayment($loan->id);

        if (!$loanHasPendingRepayments) {
            $this->loanRepository->markPaid($loan->id);
        }

        return;
    }

    private function adjustWithPendingScheduleRepayments(Loan $loan, float $extraAmount): void
    {
        $pendingScheduleRepayments = $this->repository->getPendingRepaymentsByLoanId($loan->id);

        foreach ($pendingScheduleRepayments as $pendingScheduleRepayment) {
            if ($extraAmount >= $pendingScheduleRepayment->amount_to_be_paid) {
                $this->repository->markPaid($pendingScheduleRepayment->id);

                $extraAmount -= $pendingScheduleRepayment->amount_to_be_paid;
            } else {
                $this->repository->updateAmount(
                    $pendingScheduleRepayment->id,
                    $pendingScheduleRepayment->amount_to_be_paid - $extraAmount,
                );

                return;
            }

            if ($extraAmount <= 0) {
                return;
            }
        }
    }
}
