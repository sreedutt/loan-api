<?php

namespace Tests\Feature\Loan;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Domain\Loans\Models\Loan;
use Domain\Loans\Enums\LoanStatus;
use Domain\Customers\Models\Customer;
use Illuminate\Support\Facades\Event;
use Domain\Loans\Events\LoanApprovedEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApproveLoanTest extends TestCase
{
    use RefreshDatabase;

    private Customer $admin;
    private Customer $customer;
    private Loan $loan;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = Customer::factory()->create([
            'is_admin' => true
        ]);

        $this->customer = Customer::factory()->create([
            'is_admin' => false
        ]);

        $this->loan= Loan::factory()->create([
            'customer_id' => $this->customer,
            'status' => LoanStatus::PENDING,
        ]);
    }

    public function testAdminShouldBeAbleToApproveALoan(): void
    {
        Event::fake([LoanApprovedEvent::class]);

        Sanctum::actingAs($this->admin);

        $response = $this->postJson("admin/loans/{$this->loan->uuid}/approve");

        $response
            ->assertStatus(200)
            ->assertJson([
                'uuid' => $this->loan->uuid,
                'customer' =>[
                    'email' => $this->customer->email,
                    'name' => $this->customer->name,
                    'uuid' => $this->customer->uuid,
                    'created_at' => $this->customer->created_at,
                ],
                'repayment_term' => $this->loan->repayment_term,
                'repayment_frequency' => $this->loan->repayment_frequency->value,
                'amount'    =>  $this->loan->amount,
                'interest_rate' => $this->loan->interest_rate,
                'status'    => LoanStatus::APPROVED->value,
                'approved_by' =>[
                    'email' => $this->admin->email,
                    'name' => $this->admin->name,
                    'uuid' => $this->admin->uuid,
                    'created_at' => $this->admin->created_at,
                ],
            ]);

        $this->loan->refresh();
        $this->assertEquals(LoanStatus::APPROVED, $this->loan->status);
        $this->assertEquals($this->admin->id, $this->loan->approved_by);

        Event::assertDispatched(
            LoanApprovedEvent::class,
            fn ($e) =>  $e->loan->id === $this->loan->id
        );
    }

    public function testOnlyAdminCanApproveALoanRequest()
    {
        Sanctum::actingAs($this->customer);

        $response = $this->postJson("admin/loans/{$this->loan->uuid}/approve");

        $response->assertForbidden();
        $this->assertEquals(LoanStatus::PENDING, $this->loan->refresh()->status);

        Sanctum::actingAs($this->admin);

        $response = $this->postJson("admin/loans/{$this->loan->uuid}/approve");

        $response->assertOk();
        $this->assertEquals(LoanStatus::APPROVED, $this->loan->refresh()->status);
    }

    public function testAdminCanOnlyApproveCustomersLoan()
    {
        $newAdmin = Customer::factory()->create([
            'is_admin' => true
        ]);

        $newAdminLoan= Loan::factory()->create([
            'customer_id' => $newAdmin,
            'status' => LoanStatus::PENDING,
        ]);

        Sanctum::actingAs($newAdmin);

        $response = $this->postJson("admin/loans/{$newAdminLoan->uuid}/approve");

        $response->assertForbidden();
        $this->assertEquals(LoanStatus::PENDING, $newAdminLoan->refresh()->status);

        Sanctum::actingAs($this->admin);

        $response = $this->postJson("admin/loans/{$newAdminLoan->uuid}/approve");

        $response->assertOk();
        $this->assertEquals(LoanStatus::APPROVED, $newAdminLoan->refresh()->status);
    }
}
