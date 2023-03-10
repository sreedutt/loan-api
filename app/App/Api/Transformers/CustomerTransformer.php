<?php

namespace App\Api\Transformers;

use App\Http\Transformer;

use Domain\Customers\Models\Customer;

class CustomerTransformer implements Transformer
{
    public function __construct(public Customer $customer)
    {
    }

    public function transform(): array
    {
        return[
            'email' => $this->customer->email,
            'name' => $this->customer->name,
            'uuid' => $this->customer->uuid,
            'created_at' => $this->customer->created_at->toDateTimeString(),
        ];
    }
}
