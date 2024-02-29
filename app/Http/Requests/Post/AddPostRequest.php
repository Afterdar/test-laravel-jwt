<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use App\Http\Requests\BaseRequest;
use Exception;

class AddPostRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:40'],
            'content' => ['required', 'string', 'min:6'],
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

            'content.required' => $this->getMessage('required'),
            'content.string' => $this->getMessage('string'),
            'content.min' => $this->getMessage('min'),
        ];
    }
}
