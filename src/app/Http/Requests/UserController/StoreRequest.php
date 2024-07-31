<?php

namespace App\Http\Requests\UserController;

use App\Models\Role;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'permissions' => [
                'nullable',
                'array',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    if($this->role_id == Role::where('slug', 'custom')->pluck('id')->first() && $value == null)
                    {
                        $fail('Укажите права доступа');
                    }
                }
            ],
            'phone'    => 'required|string|unique:users,phone|regex:/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле электронной почты обязательно для заполнения.',
            'email.email' => 'Введите действительный адрес электронной почты.',
            'email.unique' => 'Пользователь с таким email уже существует.',

            'role_id.required' => 'Поле роли обязательно для заполнения.',
            'role_id.exists' => 'Выбранная роль не существует.',

            'permissions.required' => 'Поле "Права доступа" обязательно для заполнения.',
            'permissions.array' => 'Поле "Права доступа" должно быть массивом.',

            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.string' => 'Поле "Телефон" должно быть строкой.',
            'phone.regex' => 'Поле "Телефон" должно быть в формате +7(999)-999-99-99.',
            'phone.unique' => 'Пользователь с таким телефоном уже существует.',
            'phone.max' => 'Поле "Телефон" не может быть длиннее 255 символов.',
        ];
    }
}
