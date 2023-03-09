<?php
namespace App\Api\Transformers;

use App\Http\Transformer;
use Domain\Customers\DataTransferObjects\CustomerData;

class CustomerTransformer implements Transformer
{
    
    public function __construct(public CustomerData $customerData)
    {
      
    }

    public function transform(): array
    {
        return[
            'email' => $this->customerData->email,
            'name' => $this->customerData->name,
            'uuid' => $this->customerData->uuid,
            'created_at' => $this->customerData->createdAt,
        ];
        
    }
}