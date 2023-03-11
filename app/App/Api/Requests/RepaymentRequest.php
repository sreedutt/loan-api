<?php

namespace App\Api\Requests;

use Domain\Loans\Enums\RepaymentStatus;
use Domain\Loans\Models\ScheduleRepayment;
use Domain\Loans\Repositories\ScheduleRepaymentRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class RepaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $scheduleRepayment = $this->getScheduleRepayment();

        return $scheduleRepayment->status === RepaymentStatus::PENDING;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
        ];
    }

    public function getScheduleRepayment(): ScheduleRepayment
    {
        return app(ScheduleRepaymentRepositoryInterface::class)->findByUuid($this->route('uuid'));
    }
}
