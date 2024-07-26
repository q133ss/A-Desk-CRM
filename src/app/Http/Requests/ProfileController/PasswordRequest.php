<?php

namespace App\Http\Requests\ProfileController;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => [
                'required',
                'string',
                'min:6',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    if(!Hash::check($value, Auth('sanctum')->user()->password)){
                        $fail('Указан неверный пароль');
                    }
                }
            ],
            'password' => 'required|string|min:6|max:255|confirmed'
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Поле "Текущий пароль" обязательно для заполнения.',
            'current_password.string' => 'Поле "Текущий пароль" должно быть строкой.',
            'current_password.min' => 'Поле "Текущий пароль" должно содержать не менее 6 символов.',

            'password.required' => 'Поле "Новый пароль" обязательно для заполнения.',
            'password.string' => 'Поле "Новый пароль" должно быть строкой.',
            'password.min' => 'Поле "Новый пароль" должно содержать не менее 6 символов.',
            'password.max' => 'Поле "Новый пароль" не может быть длиннее 255 символов.',
            'password.confirmed' => 'Подтверждение пароля не совпадает.',
        ];
    }
}
