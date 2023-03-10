<?php

namespace Domain\Loans\Enums;

enum LoanStatus: string
{
    use GetValues;
    
    case PENDING = 'pending';
    case APPROVED= 'approved';
    case REJECTED = 'rejected';
    case PAID = 'paid';

    
}

