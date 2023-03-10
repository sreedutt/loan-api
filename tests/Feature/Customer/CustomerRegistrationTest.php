<?php

namespace Tests\Feature\Customer;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Domain\Customers\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testACustomerCanRegister(): void
    {
        $response = $this->json('POST', '/api/customers', [
            'email' => 'ellend@example.com',
            'name' => 'Ellen',
            'password' => 'secret12',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'email', 'name', 'uuid', 'created_at',
            ])
            ->assertJson([
                'email' => 'ellend@example.com',
                'name' => 'Ellen',
            ]);

        $customers = Customer::all();
        $this->assertCount(1, $customers);

        $customer = $customers->first();
        $this->assertEquals('ellend@example.com', $customer->email);
        $this->assertEquals('Ellen', $customer->name);
        $this->assertTrue(Hash::check('secret12', $customer->password));
    }

    /**
     * @dataProvider inputDataforCustomerRegistration
     */
    public function testItShouldFailValidationForInvalidInput($input, $expectation): void
    {
        $response = $this->json('POST', '/api/customers', $input);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors($expectation);
    }

    public static function inputDataforCustomerRegistration()
    {
        return [
            [
                [
                    'email' => '',
                    'name' => '',
                    'password' => '',
                ],
                [
                    'email',
                    'name',
                    'password',
                ],
            ],
            [
                [
                    'email' => 'ssss',
                    'name' => 'Ellen',
                    'password' => 'secret12',
                ],
                [
                    'email',
                ],
            ],
            [
                [
                    'email' => 'ellend@example.com',
                    'name' => 'Ellen',
                    'password' => 'secret',
                ],
                [
                    'password',
                ],
            ],
        ];
    }
}
