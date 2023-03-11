<?php

namespace App\Api\Transformers;

use App\Http\Transformer;

class ScheduleRepaymentTransformer implements Transformer
{
    public function transform($repayment): array
    {
        return[
            'uuid' => $repayment->uuid,
            'amount_to_be_paid' => $repayment->amount_to_be_paid,
            'reapayment_date' => $repayment->repayment_date,
            'status' => $repayment->status,
        ];
    }
}
