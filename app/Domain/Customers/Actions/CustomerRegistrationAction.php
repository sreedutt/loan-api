<?php

namespace Domain\Customers\Actions;

use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\Repositories\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class CustomerRegistrationAction
{
    public $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CustomerData $customerData): CustomerData
    {
        $customerData->password = Hash::make($customerData->password);

        return $this->repository->store($customerData);
    }
}
