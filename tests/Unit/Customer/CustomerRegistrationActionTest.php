<?php

namespace Tests\Unit\Customer;

use Tests\TestCase;
use Mockery\MockInterface;
use Domain\Customers\Models\Customer;
use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\Actions\CustomerRegistrationAction;
use Domain\Customers\Repositories\CustomerRepositoryInterface;

class CustomerRegistrationActionTest extends TestCase
{
    public function testItShouldCallExecuteMethod(): void
    {
        $customerData = new CustomerData(
            'ellend@example.com',
            'Ellen',
            'hashed-password',
        );

        $returnedCustomerData = $this->mock(Customer::class);

        $this->instance(
            CustomerRepositoryInterface::class,
            \Mockery::mock(
                CustomerRepositoryInterface::class,
                fn (MockInterface $mock) => $mock->shouldReceive('store')
                        ->once()
                        ->with($customerData)
                        ->andReturn($returnedCustomerData)
            )
        );

        $customer = app(CustomerRegistrationAction::class)->execute($customerData);

        $this->assertSame($returnedCustomerData, $customer);
    }
}
