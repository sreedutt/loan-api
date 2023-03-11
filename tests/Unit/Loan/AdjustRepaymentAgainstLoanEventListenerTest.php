<?php

use Tests\TestCase;
use Mockery\MockInterface;
use Domain\Loans\Models\Repayment;
use Illuminate\Support\Facades\Event;
use Domain\Loans\Models\ScheduleRepayment;
use Domain\Loans\Events\RepaymentRecordedEvent;
use Domain\Loans\Actions\AdjustRepaymentAgainstLoanAction;
use Domain\Loans\Listeners\AdjustRepaymentAgainstLoanEventListener;

class AdjustRepaymentAgainstLoanEventListenerTest extends TestCase
{
    public function testRepaymentRecordedEventIsAttached()
    {
        Event::fake();

        Event::assertListening(
            RepaymentRecordedEvent::class,
            AdjustRepaymentAgainstLoanEventListener::class
        );
    }

    public function testLoanApprovedListenerCallsAction()
    {
        $scheduleRepayment= $this->mock(ScheduleRepayment::class);
        $repayment= $this->mock(Repayment::class);

        $adjustRepaymentAgainstLoanActionMock = $this->mock(
            AdjustRepaymentAgainstLoanAction::class,
            fn (MockInterface $mock) => $mock 
                ->shouldReceive('execute')
                ->once()
                ->with($repayment, $scheduleRepayment)
        );

        $listener = new AdjustRepaymentAgainstLoanEventListener($adjustRepaymentAgainstLoanActionMock);
        $listener->handle(new RepaymentRecordedEvent($repayment, $scheduleRepayment));
    }

}
