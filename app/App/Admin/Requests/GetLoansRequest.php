<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetLoansRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) true;
    }

    public function rules()
    {
        return [];
    }
}
