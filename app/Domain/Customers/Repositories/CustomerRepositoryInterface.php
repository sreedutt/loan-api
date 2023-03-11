<?php

namespace Domain\Customers\Repositories;

use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\Models\Customer;

interface CustomerRepositoryInterface
{
    public function store(CustomerData $customerData): Customer;
}
