<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'required|string|unique:users,phone|regex:/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
            'password' => 'required|string|min:6|max:255|confirmed'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Поле "Имя" не может быть длиннее 255 символов.',
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Поле "Email" должно быть действительным адресом электронной почты.',
            'email.max' => 'Поле "Email" не может быть длиннее 255 символов.',
            'email.unique' => 'Пользователь с таким "Email" уже существует.',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.string' => 'Поле "Телефон" должно быть строкой.',
            'phone.regex' => 'Поле "Телефон" должно быть в формате +7(999)-999-99-99.',
            'phone.unique' => 'Пользователь с таким телефоном уже существует.',
            'phone.max' => 'Поле "Телефон" не может быть длиннее 255 символов.',
            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.string' => 'Поле "Пароль" должно быть строкой.',
            'password.min' => 'Поле "Пароль" должно содержать не менее 6 символов.',
            'password.max' => 'Поле "Пароль" не может быть длиннее 255 символов.',
            'password.confirmed' => 'Поле "Пароль" должно быть подтверждено.'
        ];
    }
}
