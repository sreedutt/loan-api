<?php
namespace Domain\Customers\DataTransferObjects;

use App\Api\Requests\CustomerRegistrationRequest;
use Carbon\Carbon;
use Domain\Customers\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerData
{
    public string $email;
    public string $name;
    public ?string $password = null;
    public ?string $uuid = null;
    public ?Carbon $createdAt = null;

    public function __construct(string $email, string $name, ?string $password = null)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    public static function fromRequest(CustomerRegistrationRequest $request): CustomerData
    {
        return new static(
            $request->input('email'), 
            $request->input('name'), 
            $request->input('password')
        );
        
    }

    public static function fromModel(Customer $customer): CustomerData
    {

        $self =  new static(
            $customer->email,
            $customer->name,             
        );

        $self->uuid = $customer->uuid;
        $self->createdAt = $customer->created_at;
        
        return $self;
    }
}