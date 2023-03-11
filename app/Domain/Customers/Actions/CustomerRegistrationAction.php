<?php

namespace Domain\Customers\Actions;

use Illuminate\Support\Facades\Hash;
use Domain\Customers\Models\Customer;
use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\Repositories\CustomerRepositoryInterface;

class CustomerRegistrationAction
{
    public $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CustomerData $customerData): Customer
    {
        $customerData->password = Hash::make($customerData->password);

        return $this->repository->store($customerData);
    }
}
