<?php

namespace Tests\Feature\Customer;

use Domain\Customers\Models\Customer;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewLoanTest extends TestCase
{
    use RefreshDatabase;

    public function testACustomerCanViewHisLoan(): void
    {
        $customer = Customer::factory()->create();

        Sanctum::actingAs($customer);

        $loan = Loan::factory()->create([
            'customer_id' => $customer,
        ]);

        $response = $this->getJson("/api/loans/{$loan->uuid}");

        $response
            ->assertOk()
            ->assertJson([
                'uuid' => $loan->uuid,
                'customer' =>[
                    'email' => $customer->email,
                    'name' => $customer->name,
                    'uuid' => $customer->uuid,
                    'created_at' => $customer->created_at->toDateTimeString(),
                ],
                'repayment_term' => $loan->repayment_term,
                'repayment_frequency' => $loan->repayment_frequency->value,
                'amount' =>  $loan->amount,
                'interest_rate' => $loan->interest_rate,
                'status' => LoanStatus::PENDING->value,
                'created_at' => $loan->created_at->toDateTimeString(),
                'approved_at' => $loan->approved_at,
                'approved_by' => $loan->approved_by,
            ]);


        $newCustomer = Customer::factory()->create();

        Sanctum::actingAs($newCustomer);

        $response = $this->getJson("/api/loans/{$loan->uuid}");

        $response->assertForbidden();
    }
}
