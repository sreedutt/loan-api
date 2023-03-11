<?php

namespace App\Api\Transformers;

use App\Http\Transformer;

class RepaymentTransformer implements Transformer
{
    public function transform($repayment): array
    {
        return[
            'uuid' => $repayment->uuid,
            'loan_uuid' => $repayment->loan->uuid,
            'amount_paid' => $repayment->amount_paid,
            'paid_date' => $repayment->paid_date->toDateString(),
        ];
    }
}
