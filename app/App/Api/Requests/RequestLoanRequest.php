<?php
namespace App\Api\Requests;

use Domain\Loans\Enums\RepaymentFrequency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RequestLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'repayment_term' => ['required', 'numeric' ],
            'repayment_frequency' => ['required', new Enum(RepaymentFrequency::class)],
            'amount' => ['required', 'numeric'],
        ];
    }
}