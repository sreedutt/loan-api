<?php

namespace Tests\Unit\Loan;

use Domain\Loans\Actions\CreateScheduledRepaymentsAction;
use Domain\Loans\Events\LoanApprovedEvent;
use Domain\Loans\Listeners\LoanApprovedEventListener;
use Domain\Loans\Models\Loan;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Tests\TestCase;

class LoanApprovedEventListenerTest extends TestCase
{
    public function testLoanApprovedEventIsAttached()
    {
        Event::fake();

        Event::assertListening(
            LoanApprovedEvent::class,
            LoanApprovedEventListener::class
        );
    }

    public function testLoanApprovedListenerCallsAction()
    {
        $loan= $this->mock(Loan::class);

        $createScheduleRepaymentActionMock = $this->mock(
            CreateScheduledRepaymentsAction::class,
            fn (MockInterface $mock) => $mock -> shouldReceive('execute')
                    ->once()
                    ->with($loan)
        );

        $listener = new LoanApprovedEventListener($createScheduleRepaymentActionMock);
        $listener->handle(new LoanApprovedEvent($loan));
    }
}
