<?php
namespace Domain\Customers\Repositories;

use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    
    public function store(CustomerData $customerData) : CustomerData
    {
        $customer = new Customer();
        $customer->email = $customerData->email;
        $customer->name  = $customerData->name;
        $customer->password = $customerData->password;
        
        $customer->save();

        return CustomerData::fromModel($customer);

    }
}