<?php

namespace Domain\Loans\Factories;

use Domain\Customers\Models\Customer;
use Domain\Loans\Enums\LoanStatus;
use Domain\Loans\Enums\RepaymentFrequency;
use Domain\Loans\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory()->create(),
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::WEEKLY,
            'amount' => 10000,
            'interest_rate' => 10,
            'status' => LoanStatus::PENDING,
        ];
    }
}
