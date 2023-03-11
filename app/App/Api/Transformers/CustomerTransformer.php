<?php

namespace App\Api\Transformers;

use App\Http\Transformer;

class CustomerTransformer implements Transformer
{
    public function transform($customer): array
    {
        return[
            'email' => $customer->email,
            'name' => $customer->name,
            'uuid' => $customer->uuid,
            'created_at' => $customer->created_at->toDateTimeString(),
        ];
    }
}
