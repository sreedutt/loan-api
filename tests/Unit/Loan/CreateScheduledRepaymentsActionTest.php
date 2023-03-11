<?php

namespace Tests\Unit\Loan;

use Carbon\Carbon;
use Domain\Loans\Actions\CreateScheduledRepaymentsAction;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Enums\RepaymentFrequency;
use Domain\Loans\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateScheduledRepaymentsActionTest extends TestCase
{
    use RefreshDatabase;

    public function testWeeklyScheduleRepaymentCalculation(): void
    {
        $dateT = Carbon::parse('2023-03-01');
        Carbon::setTestNow($dateT);

        $loan= Loan::factory()->create([
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::WEEKLY,
            'amount' => 10000,
            'interest_rate' => 0,
            'status' => LoanStatus::APPROVED,
        ]);

        app(CreateScheduledRepaymentsAction::class)->execute($loan);

        $this->assertDatabaseCount('schedule_repayments', 3);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3333.33,
            'repayment_date' => '2023-03-08',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3333.33,
            'repayment_date' => '2023-03-15',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3333.34,
            'repayment_date' => '2023-03-22',
            'status' => 'pending',
        ]);
    }

    public function testMonthlyScheduleRepaymentCalculation(): void
    {
        $dateT = Carbon::parse('2023-03-01');
        Carbon::setTestNow($dateT);

        $loan= Loan::factory()->create([
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::MONTHLY,
            'amount' => 10000,
            'interest_rate' => 10,
            'status' => LoanStatus::APPROVED,
        ]);

        app(CreateScheduledRepaymentsAction::class)->execute($loan);


        $this->assertDatabaseCount('schedule_repayments', 3);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3416.67,
            'repayment_date' => '2023-04-01',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3416.67,
            'repayment_date' => '2023-05-01',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3416.66,
            'repayment_date' => '2023-06-01',
            'status' => 'pending',
        ]);
    }

    public function testQuartertlyScheduleRepaymentCalculation(): void
    {
        $dateT = Carbon::parse('2023-03-01');
        Carbon::setTestNow($dateT);

        $loan= Loan::factory()->create([
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::QUARTERLY,
            'amount' => 10000,
            'interest_rate' => 10,
            'status' => LoanStatus::APPROVED,
        ]);

        app(CreateScheduledRepaymentsAction::class)->execute($loan);


        $this->assertDatabaseCount('schedule_repayments', 3);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3583.33,
            'repayment_date' => '2023-07-01',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3583.33,
            'repayment_date' => '2023-11-01',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 3583.34,
            'repayment_date' => '2024-03-01',
            'status' => 'pending',
        ]);
    }

    public function testYearlyScheduleRepaymentCalculation(): void
    {
        $dateT = Carbon::parse('2023-03-01');
        Carbon::setTestNow($dateT);

        $loan= Loan::factory()->create([
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::YEARLY,
            'amount' => 10000,
            'interest_rate' => 10,
            'status' => LoanStatus::APPROVED,
        ]);

        app(CreateScheduledRepaymentsAction::class)->execute($loan);


        $this->assertDatabaseCount('schedule_repayments', 3);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 4333.33,
            'repayment_date' => '2024-03-01',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 4333.33,
            'repayment_date' => '2025-03-01',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('schedule_repayments', [
            'loan_id' => 1,
            'amount_to_be_paid' => 4333.34,
            'repayment_date' => '2026-03-01',
            'status' => 'pending',
        ]);
    }
}
