<?php

namespace Domain\Loans\Enums;

enum RepaymentStatus: string
{
    use GetValues;

    case PENDING = 'pending';
    case PAID = 'paid';
}
