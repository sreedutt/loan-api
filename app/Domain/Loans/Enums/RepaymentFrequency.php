<?php

namespace Domain\Loans\Enums;

use Domain\Loans\Enums\GetValues;

enum RepaymentFrequency: string
{
    use GetValues;

    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case YEARLY = 'yearly';
}
