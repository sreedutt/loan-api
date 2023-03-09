<?php
namespace App\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CustomerRegistrationRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'=> ['required', 'unique:customers', 'email',],
            'name' => ['required',],
            'password' => ['required', Password::min(8)],
        ];
    }

}