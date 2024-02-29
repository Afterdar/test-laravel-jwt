<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Exception;

class AuthUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'min:3', 'max:40'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * @throws Exception
     */
    public function messages(): array
    {
        return [
            'email.required' => $this->getMessage('required'),
            'email.email' => $this->getMessage('email'),
            'email.max' => $this->getMessage('max'),
            'email.min' => $this->getMessage('min'),

            'password.required' => $this->getMessage('required'),
            'password.string' => $this->getMessage('string'),
            'password.min' => $this->getMessage('min'),
        ];
    }
}
