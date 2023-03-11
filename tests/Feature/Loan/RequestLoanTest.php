<?php

namespace Tests\Feature\Loan;

use Domain\Customers\Models\Customer;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Enums\RepaymentFrequency;
use Domain\Loans\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RequestLoanTest extends TestCase
{
    use RefreshDatabase;

    public function testACustomerCanRequestForALoan(): void
    {
        $customer = Customer::factory()->create();

        Sanctum::actingAs($customer);

        $response = $this->json('POST', '/api/loans', [
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::WEEKLY,
            'amount' => 10000,
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'customer' =>[
                    'email' => $customer->email,
                    'name' => $customer->name,
                    'uuid' => $customer->uuid,
                    'created_at' => $customer->created_at,
                ],
                'repayment_term' => 3,
                'repayment_frequency' => RepaymentFrequency::WEEKLY->value,
                'amount' => 10000,
                'interest_rate' => Loan::INTEREST_RATE,
                'status' => LoanStatus::PENDING->value,
            ]);
    }

    /**
     * @dataProvider inputDataforRequestLoan
     */
    public function testItShouldFailValidationForInvalidInput($input, $expectation): void
    {
        $customer = Customer::factory()->create();

        Sanctum::actingAs($customer);

        $response = $this->json('POST', '/api/loans', $input);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors($expectation);
    }

    public function testALoanRequestCanBeDoneByALoggedInCustomer(): void
    {
        $response = $this->json('POST', '/api/loans', [
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::WEEKLY,
            'amount' => 10000,
        ]);

        $response->assertUnauthorized();
    }

    public static function inputDataforRequestLoan()
    {
        return [
            [
                [
                    'repayment_term' => '',
                    'repayment_frequency' => '',
                    'amount' => '',

                ],
                [
                    'repayment_term',
                    'repayment_frequency',
                    'amount',
                ],
            ],
            [
                [
                    'repayment_term' => 'three',
                    'repayment_frequency' => 'weekly',
                    'amount' => 10000,
                ],
                [
                    'repayment_term',
                ],
            ],
            [
                [
                    'repayment_term' => 3,
                    'repayment_frequency' => 'daily',
                    'amount' => 10000,
                ],
                [
                    'repayment_frequency',
                ],
            ],
            [
                [
                    'repayment_term' => 3,
                    'repayment_frequency' => 'weekly',
                    'amount' => 'hundred',
                ],
                [
                    'amount',
                ],
            ],
        ];
    }
}
