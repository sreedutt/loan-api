<?php
namespace Tests\Unit\Loan;

use Tests\TestCase;
use Domain\Loans\Models\Loan;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Models\Repayment;
use Domain\Loans\Enums\RepaymentStatus;
use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Domain\Loans\Actions\AdjustRepaymentAgainstLoanAction;

class AdjustRepaymentAgainstLoanActionTest extends TestCase
{
    use RefreshDatabase;

    public function testLoanAndScheduledRepaymentWillBeMarkedAsPaid()
    {
        $loan = Loan::factory()->create([
            'repayment_term' => 1,
            'status' => LoanStatus::APPROVED,
        ]);

        $scheduleRepayment = ScheduleRepayment::factory()->create([
            'loan_id' => $loan->id,
            'amount_to_be_paid' => 3000,
            'status' => RepaymentStatus::PENDING,
        ]);

        $repayment = Repayment::factory()->create([
            'loan_id' => $loan->id,
            'amount_paid' => 3000,
        ]);

        $action = app(AdjustRepaymentAgainstLoanAction::class);

        $action->execute($repayment, $scheduleRepayment);

        $this->assertEquals(LoanStatus::PAID, $loan->refresh()->status);
        $this->assertEquals(RepaymentStatus::PAID, $scheduleRepayment->refresh()->status);
    }
    
    public function testLoanAndScheduledRepaymentWithAmountPaidGreaterThanPendingAmount()
    {
        $loan = Loan::factory()->create([
            'repayment_term' => 2,
            'status' => LoanStatus::APPROVED,
        ]);

        [$scheduleRepaymentOne, $scheduleRepaymentTwo] = ScheduleRepayment::factory()
            ->count(2)
            ->create([
                'loan_id' => $loan->id,
                'amount_to_be_paid' => 3000,
                'status' => RepaymentStatus::PENDING,
            ]);

        $repayment = Repayment::factory()->create([
            'loan_id' => $loan->id,
            'amount_paid' => 4000,
        ]);

        $action = app(AdjustRepaymentAgainstLoanAction::class);

        $action->execute($repayment, $scheduleRepaymentOne);

        $this->assertEquals(LoanStatus::APPROVED, $loan->refresh()->status);
        $this->assertEquals(RepaymentStatus::PAID, $scheduleRepaymentOne->refresh()->status);
        $this->assertEquals(RepaymentStatus::PENDING, $scheduleRepaymentTwo->refresh()->status);
        $this->assertEquals(2000, $scheduleRepaymentTwo->amount_to_be_paid);
    }

    public function testLoanAndScheduledRepaymentWithAmountPaidLessThanPendingAmount()
    {
        $loan = Loan::factory()->create([
            'repayment_term' => 1,
            'status' => LoanStatus::APPROVED,
        ]);

        $scheduleRepayment = ScheduleRepayment::factory()->create([
            'loan_id' => $loan->id,
            'amount_to_be_paid' => 3000,
            'status' => RepaymentStatus::PENDING,
        ]);

        $repayment = Repayment::factory()->create([
            'loan_id' => $loan->id,
            'amount_paid' => 2000,
        ]);

        $action = app(AdjustRepaymentAgainstLoanAction::class);

        $action->execute($repayment, $scheduleRepayment);

        $this->assertEquals(LoanStatus::APPROVED, $loan->refresh()->status);
        $this->assertEquals(RepaymentStatus::PENDING, $scheduleRepayment->refresh()->status);
        $this->assertEquals(1000, $scheduleRepayment->amount_to_be_paid);
    }
    
}