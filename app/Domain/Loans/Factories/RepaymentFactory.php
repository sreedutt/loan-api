<?php

namespace Domain\Loans\Factories;

use Carbon\Carbon;
use Domain\Customers\Models\Customer;
use Domain\Loans\Models\Loan;
use Domain\Loans\Models\Repayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepaymentFactory extends Factory
{
    protected $model = Repayment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return  [
            'customer_id' => Customer::factory()->create(),
            'loan_id' => Loan::factory()->create(),
            'amount_paid' => 3333,
            'paid_date' => Carbon::now()
        ];
    }
}
