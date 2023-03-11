<?php

namespace Domain\Loans\Factories;

use Domain\Loans\Enums\RepaymentStatus;
use Domain\Loans\Models\ScheduleRepayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleRepaymentFactory extends Factory
{
    protected $model = ScheduleRepayment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return  [
            'amount_to_be_paid' => 3333,
            'status'   => RepaymentStatus::PENDING,
        ];
    }
}
