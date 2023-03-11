<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Domain\Loans\Models\Loan;
use Domain\Customers\Models\Customer;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewLoansTest extends TestCase
{
    use RefreshDatabase;

    public function testACustomerCanViewHisLoans(): void
    {
        $customer = Customer::factory()->create();
        $anotherCustomer = Customer::factory()->create();

        Sanctum::actingAs($customer);

        [$loanOne, $loanTwo, $loanThree, $loanFour] = Loan::factory()
            ->count(4)
            ->sequence(
                ['customer_id' => $customer->id],
                ['customer_id' => $customer->id],
                ['customer_id' => $customer->id],
                ['customer_id' => $anotherCustomer->id],
            )
            ->create();

        $response = $this->getJson("/api/loans");

        $response->assertOk();

        $response
        ->assertJson(
            fn (AssertableJson $json) =>
                $json->has('pagination')
                    ->has('data', 3)
                    ->has(
                        'data.0',
                        fn (AssertableJson $json) =>
                            $json->where('uuid', $loanOne->uuid)->etc()
                    )
                    ->has(
                        'data.1',
                        fn (AssertableJson $json) =>
                            $json->where('uuid', $loanTwo->uuid)->etc()
                    )
                    ->has(
                        'data.2',
                        fn (AssertableJson $json) =>
                            $json->where('uuid', $loanThree->uuid)->etc()
                    )
        );

        Sanctum::actingAs($anotherCustomer);

        $response = $this->getJson("/api/loans");

        $response->assertOk();

        $response
        ->assertJson(
            fn (AssertableJson $json) =>
                $json->has('pagination')
                    ->has('data', 1)
                    ->has(
                        'data.0',
                        fn (AssertableJson $json) =>
                            $json->where('uuid', $loanFour->uuid)->etc()
                    )
        );
    }
}
