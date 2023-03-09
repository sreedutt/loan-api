<?php

namespace Domain\Customers\Repositories;

use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\DataTransferObjects\CustomerLogin;

interface CustomerRepositoryInterface
{
    public function store(CustomerData $customerData): CustomerData;

    
}
