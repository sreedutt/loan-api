<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Domain\Loans\Models\Loan;
use Domain\Customers\Models\Customer;
use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetScheduleRepaymentsForLoanTest extends TestCase
{
    use RefreshDatabase;

    public function testCustomerCanViewScheduleRepaymentsOfALoan()
    {
        $customer = Customer::factory()->create();
        $anotherCustomer = Customer::factory()->create();

        $loan = Loan::factory()->create([
            'customer_id' => $customer->id,
        ]);

        [$scheduledRepaymentOne, $scheduledRepaymentTwo] = ScheduleRepayment::factory()
            ->count(2)
            ->create([
                'loan_id' => $loan->id,
            ]);

        Sanctum::actingAs($customer);

        $response = $this->getJson("/api/loans/{$loan->uuid}/scheduled-repayments");

        $response->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
                    $json->has('pagination')
                        ->has('data', 2)
                        ->has(
                            'data.0',
                            fn (AssertableJson $json) =>
                                $json->where('uuid', $scheduledRepaymentOne->uuid)->etc()
                        )
                        ->has(
                            'data.1',
                            fn (AssertableJson $json) =>
                                $json->where('uuid', $scheduledRepaymentTwo->uuid)->etc()
                        )
            );

        Sanctum::actingAs($anotherCustomer);

        $response = $this->getJson("/api/loans/{$loan->uuid}/scheduled-repayments");

        $response->assertForbidden();
    }
}
