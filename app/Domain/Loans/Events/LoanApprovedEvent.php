<?php

namespace Domain\Loans\Events;

use Domain\Loans\Models\Loan;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class LoanApprovedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public Loan $loan)
    {
    }
}
