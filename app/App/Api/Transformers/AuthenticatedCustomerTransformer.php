<?php

namespace App\Api\Transformers;

use App\Http\Transformer;
use Domain\Customers\DataTransferObjects\CustomerData;

class AuthenticatedCustomerTransformer implements Transformer
{
    public function transform($customer): array
    {
        return [
            'email' => $customer->email,
            'name' => $customer->name,
            'uuid' => $customer->uuid,
            'token' => $customer->token,
        ];
    }
}
