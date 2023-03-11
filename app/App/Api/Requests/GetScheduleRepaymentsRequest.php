<?php

namespace App\Api\Requests;

use Domain\Loans\Models\Loan;
use Domain\Loans\Repositories\LoanRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class GetScheduleRepaymentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        $loan = $this->getLoan();

        return $loan->customer_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [];
    }

    public function getLoan(): Loan
    {
        return app(LoanRepositoryInterface::class)->findByUUID($this->route('uuid'));
    }
}
