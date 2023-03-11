<?php

namespace App\Api\Requests;

use Domain\Loans\Repositories\LoanRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class GetLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $loan = $this->getLoan();

        return $this->user()->can('view', $loan);
    }

    public function rules()
    {
        return [];
    }

    public function getLoan()
    {
        return app(LoanRepositoryInterface::class)->findByUUID($this->route('uuid'));
    }
}
