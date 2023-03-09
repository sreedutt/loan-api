<?php

namespace App\Api\Controllers;

use App\Api\Requests\CustomerRegistrationRequest;
use App\Api\Transformers\CustomerTransformer;
use App\Http\Controller;
use Domain\Customers\Actions\CustomerRegistrationAction;
use Domain\Customers\DataTransferObjects\CustomerData;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function store(CustomerRegistrationRequest $request, CustomerRegistrationAction $action): JsonResponse
    {
        $customerData = $action->execute(CustomerData::fromRequest($request));

        return $this->respondCreated(new CustomerTransformer($customerData));
    }
}
