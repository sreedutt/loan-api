<?php

namespace App\Api\Controllers;

use App\Api\Requests\CustomerLoginRequest;
use App\Api\Requests\CustomerRegistrationRequest;
use App\Api\Transformers\AuthenticatedCustomerTransformer;
use App\Api\Transformers\CustomerTransformer;
use App\Http\Controller;
use Domain\Customers\Actions\CustomerRegistrationAction;
use Domain\Customers\DataTransferObjects\CustomerData;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function store(CustomerRegistrationRequest $request, CustomerRegistrationAction $action): JsonResponse
    {
        $customerData = $action->execute(CustomerData::fromRequest($request));

        return $this->respondCreated(new CustomerTransformer($customerData));
    }

    public function login(CustomerLoginRequest $request): JsonResponse
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            throw new AuthenticationException('Invalid credentials');
        }

        $customer = Auth::user();
        $token = $customer->createToken(now())->plainTextToken;

        $customerData = CustomerData::fromModelWithToken($customer, $token);

        return $this->respondOk(new AuthenticatedCustomerTransformer($customerData));
    }
}
