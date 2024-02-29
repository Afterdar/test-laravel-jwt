<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /** @var array<string, string> */
    private array $messages = [
        'required' => 'Поле :attribute обязательное к заполнению',
        'string' => 'Поле :attribute должно быть строкой',
        'email' => 'Введите корректный email адрес.',
        'exists' => 'Сущности с указанным :attribute не существует.',
        'integer' => 'Поле :attribute должно быть целочисленным числом',
        'numeric' => 'Поле :attribute должно быть числом',
        'min' => 'Поле :attribute должен быть не меньше :min.',
        'max' => 'Поле :attribute должен быть не больше :max.',
        'in' => 'Поле :attribute должно содержать в себе один из параметров [:values].',
        'file' => 'Поле :attribute должно быть файлом.',
        'mimes' => 'Файл должен иметь одно из расширений [:values].',
        'unique' => 'Сущность с указанным :attribute уже существует.',
        'boolean' => 'Поле :attribute должно быть true или false.',
        'date' => 'Поле :attribute должно быть датой',
        'regex' => 'Поле :attribute обязательно должно быть по форме +7'
    ];

    /** @return bool */
    public function authorize(): bool
    {
        return true;
    }

    protected function getMessage(string $type): string
    {
        if ($this->exist($type)) {
            return $this->messages[$type];
        }

        return '';
    }

    private function exist(string $type): bool
    {
        return !empty($this->messages[$type]);
    }
}
