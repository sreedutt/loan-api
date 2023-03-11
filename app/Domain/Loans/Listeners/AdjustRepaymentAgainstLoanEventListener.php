<?php

namespace Domain\Loans\Listeners;

use Domain\Loans\Actions\AdjustRepaymentAgainstLoanAction;

use Domain\Loans\Events\RepaymentRecordedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdjustRepaymentAgainstLoanEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(private AdjustRepaymentAgainstLoanAction $action)
    {
    }

    public function handle(RepaymentRecordedEvent $event)
    {
        $this->action->execute($event->repayment, $event->scheduleRepayment);
    }
}
