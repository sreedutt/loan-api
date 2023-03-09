<?php

namespace Tests\Feature\Customer;

use Domain\Customers\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerLoginTest extends TestCase
{
    use RefreshDatabase;

    public function testACustomerCanLogin(): void
    {
        $customer = Customer::factory()->create([
            'email' => 'ellend@example.com',
        ]);

        $response = $this->json('POST', 'api/customers/login', [
          'email' => 'ellend@example.com',
          'password' => 'password',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'email', 'name', 'uuid', 'token',
            ])
            ->assertJson([
                'email' => 'ellend@example.com',
            ]);

        $token = explode('|', $response->json()['token'])[1];

        $this->assertDatabaseHas('personal_access_tokens', [
            'token' => hash('sha256', $token),
        ]);
    }

    public function testInvalidEmailInLogin(): void
    {
        $this->json('POST', 'api/customers/login', [
            'email' => 'invalid@example.com',
            'password' => 'password',
        ])->assertUnauthorized();
    }
}
