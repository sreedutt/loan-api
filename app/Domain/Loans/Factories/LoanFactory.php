<?php

namespace Domain\Loans\Factories;

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
            'repayment_term' => 3,
            'repayment_frequency' => RepaymentFrequency::WEEKLY,
            'amount' => 10000,
            'interest_rate' => 10,
            'status' => 'PENDING',
        ];
    }
}