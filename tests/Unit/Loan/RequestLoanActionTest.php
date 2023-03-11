<?php

namespace Tests\Unit\Loan;

use Tests\TestCase;
use Domain\Loans\Models\Loan;
use Domain\Loans\Enums\LoanStatus;
use Domain\Customers\Models\Customer;
use Domain\Loans\Actions\RequestLoanAction;
use Domain\Loans\Enums\RepaymentFrequency;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestLoanActionTest extends TestCase
{
    use RefreshDatabase;

    public function testLoanWillBeStored(): void
    {
        $customer = Customer::factory()->create();

        $requestLoan = [
            'customer_id' => $customer->id,
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::WEEKLY,
            'amount' => 10000,
            'interest_rate' => Loan::INTEREST_RATE,
            'status' => LoanStatus::PENDING,
        ];

        $loan = app(RequestLoanAction::class)->execute($requestLoan);

        $this->assertTrue($loan->exists);

        $this->assertEquals($customer->id, $loan->customer->id);
        $this->assertEquals(3, $loan->repayment_term);
        $this->assertEquals(RepaymentFrequency::WEEKLY, $loan->repayment_frequency);
        $this->assertEquals(10000, $loan->amount);
        $this->assertEquals(Loan::INTEREST_RATE, $loan->interest_rate);
        $this->assertEquals(LoanStatus::PENDING, $loan->status);
    }
}
