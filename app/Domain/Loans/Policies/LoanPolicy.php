<?php

namespace Domain\Loans\Policies;

use Domain\Customers\Models\Customer;
use Domain\Loans\Models\Loan;

class LoanPolicy
{
    public function approve(Customer $customer, Loan $loan)
    {
        return $customer->isAdmin()
            && $loan->isPending()
            && $loan->customer_id !== $customer->id;
    }
}
