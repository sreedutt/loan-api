<?php

namespace App\Api\Transformers;

use App\Http\Transformer;
use Domain\Loans\Models\Loan;

class LoanTransformer implements Transformer
{
    public function __construct(public Loan $loan)
    {
    }

    public function transform(): array
    {
        return[
            'uuid' => $this->loan->uuid,
            'customer' => (new CustomerTransformer($this->loan->customer))->transform(),
            'repayment_term' => $this->loan->repayment_term,
            'repayment_frequency' => $this->loan->repayment_frequency,
            'amount' => $this->loan->amount,
            'interest_rate' => $this->loan->interest_rate,
            'status' => $this->loan->status,
            'created_at' => $this->loan->created_at,
            'approved_at' => $this->loan->approved_at,
            'approved_by' => (new CustomerTransformer($this->loan->approver))->transform(),
        ];
    }
}
