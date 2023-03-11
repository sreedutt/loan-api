<?php

namespace App\Api\Transformers;

use App\Http\Transformer;

class LoanTransformer implements Transformer
{
    public function transform($loan): array
    {
        return[
            'uuid' => $loan->uuid,
            'customer' => (new CustomerTransformer())->transform($loan->customer),
            'repayment_term' => $loan->repayment_term,
            'repayment_frequency' => $loan->repayment_frequency,
            'amount' => $loan->amount,
            'interest_rate' => $loan->interest_rate,
            'status' => $loan->status,
            'created_at' => $loan->created_at,
            'approved_at' => $loan->approved_at,
            'approved_by' => $loan->approver != null ? (new CustomerTransformer())->transform($loan->approver) : null,
        ];
    }
}
