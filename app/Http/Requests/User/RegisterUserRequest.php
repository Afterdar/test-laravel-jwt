<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Exception;

class RegisterUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:40'],
            'email' => ['required', 'email', 'unique:users', 'min:3', 'max:40'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * @throws Exception
     */
    public function messages(): array
    {
        return [
            'name.required' => $this->getMessage('required'),
            'name.string' => $this->getMessage('string'),
            'name.max' => $this->getMessage('max'),
            'name.min' => $this->getMessage('min'),

            'email.required' => $this->getMessage('required'),
            'email.email' => $this->getMessage('email'),
            'email.unique' => $this->getMessage('unique'),
            'email.max' => $this->getMessage('max'),
            'email.min' => $this->getMessage('min'),

            'password.required' => $this->getMessage('required'),
            'password.string' => $this->getMessage('string'),
            'password.min' => $this->getMessage('min'),
        ];
    }
}
