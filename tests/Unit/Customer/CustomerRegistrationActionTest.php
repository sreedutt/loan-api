<?php

namespace Tests\Unit\Customer;

use Domain\Customers\Actions\CustomerRegistrationAction;
use Domain\Customers\DataTransferObjects\CustomerData;
use Domain\Customers\Repositories\CustomerRepositoryInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class CustomerRegistrationActionTest extends TestCase
{
    public function testItShouldCallExecuteMethod(): void
    {
        $customerData = new CustomerData(
            'ellend@example.com',
            'Ellen',
            'hashed-password',
        );

        $returnedCustomerData = $this->mock(CustomerData::class);

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

        $customerData = app(CustomerRegistrationAction::class)->execute($customerData);

        $this->assertSame($returnedCustomerData, $customerData);
    }
}
