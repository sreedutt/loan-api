<?php
namespace Domain\Loans\Listeners;

use Domain\Loans\Actions\CreateScheduledRepaymentsAction;
use Domain\Loans\Events\LoanApprovedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoanApprovedEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(private CreateScheduledRepaymentsAction $action)
    {
        
    }

    public function handle(LoanApprovedEvent $event)
    {
        $this->action->execute($event->loan);
    }
}