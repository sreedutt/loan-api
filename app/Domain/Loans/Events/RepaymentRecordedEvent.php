<?php

namespace Domain\Loans\Events;

use Domain\Loans\Models\Repayment;
use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RepaymentRecordedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Repayment $repayment, public ScheduleRepayment $scheduleRepayment)
    {
    }
}
