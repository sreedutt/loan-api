<?php

namespace Tests\Unit\Customer;

use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public CustomerRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new CustomerRepository();
    }

    public function testItShouldStoreCustomerData(): void
    {
        $customerData = new CustomerData('ellend@example.com', 'Ellen', 'hashed_password');

        $storedCustomerData = $this->repository->store($customerData);

        $this->assertDatabaseHas('customers', [
            'email' => $customerData->email,
            'name' => $customerData->name,
            'password' => $customerData->password,
        ]);

        $this->assertEquals($customerData->email, $storedCustomerData->email);
        $this->assertEquals($customerData->name, $storedCustomerData->name);
        $this->assertNotNull($storedCustomerData->uuid);
    }
}
