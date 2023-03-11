<?php

namespace Tests\Feature\Customer;

use Carbon\Carbon;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Domain\Loans\Models\Loan;
use Domain\Customers\Models\Customer;
use Domain\Loans\Enums\LoanStatus;
use Illuminate\Support\Facades\Event;
use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Domain\Loans\Events\RepaymentRecordedEvent;
use Domain\Loans\Models\Repayment;

class CustomerMakeRepaymentTest extends TestCase
{
    use RefreshDatabase;

    public function testAcustomerCanMakeRepayment(): void
    {
        Event::fake([RepaymentRecordedEvent::class]);

        $customer = Customer::factory()->create();

        Sanctum::actingAs($customer);

        $loan= Loan::factory()->create([
            'customer_id' => $customer,
            'status' => LoanStatus::APPROVED,
        ]);

        $scheduleRepayment = ScheduleRepayment::factory()->create([
            'loan_id' => $loan->id,
            'repayment_date' => Carbon::now()->addDays(7),
        ]);

        $amount = 4333;
        $response = $this->json('POST', "/api/scheduled-repayments/{$scheduleRepayment->uuid}/repayments", [
            'amount' => $amount,
        ]);

        $repayments = Repayment::all();
        $this->assertCount(1, $repayments);

        $repayment = $repayments->first();

        $response
            ->assertOk()
            ->assertJson([
                'uuid' => $repayment->uuid,
                'loan_uuid' => $loan->uuid,
                'amount_paid' => $amount,
                'paid_date' => $repayment->paid_date->toDateString(),
            ]);

        Event::assertDispatched(
            RepaymentRecordedEvent::class,
            fn (RepaymentRecordedEvent $event)
                => $event->repayment->id === $repayment->id
                    && $event->scheduleRepayment->id === $scheduleRepayment->id,
        );
    }
}
