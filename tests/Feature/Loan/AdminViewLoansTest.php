<?php

namespace Tests\Feature\Loan;

use Domain\Customers\Models\Customer;
use Domain\Loans\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminViewLoansTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanViewAllLoans(): void
    {
        $admin = Customer::factory()->create([
            'is_admin' => true
        ]);



        $customerOne = Customer::factory()->create([
            'is_admin' => false
        ]);

        Sanctum::actingAs($customerOne);

        $loanOne = Loan::factory()->create([
            'customer_id' => $customerOne,
        ]);


        $customerTwo = Customer::factory()->create([
            'is_admin' => false
        ]);

        Sanctum::actingAs($customerTwo);

        $loanTwo = Loan::factory()->create([
            'customer_id' => $customerOne,
        ]);


        Sanctum::actingAs($admin);
        $response = $this->getJson('/admin/loans');

        $response->assertOk(true);


        $response
        ->assertJson(
            fn (AssertableJson $json) =>
                $json->has('pagination')
                    ->has('data', 2)
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
        );
    }
}
