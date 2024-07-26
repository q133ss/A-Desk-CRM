<?php

namespace App\Http\Requests\ProfileController;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'avatar' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg',        // Разрешенные типы изображений
                'max:2048',                  // Максимальный размер в КБ (2 MB)
            ],
            'email' => 'required|email|unique:users,email,'.Auth('sanctum')->id(),
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/|unique:users,phone,'.Auth('sanctum')->id(),
            'show_pennies' => 'required|in:0,1',
            'show_description' => 'required|in:0,1'
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.nullable' => 'Файл аватара не обязателен.',
            'avatar.file' => 'Файл аватара должен быть файлом.',
            'avatar.mimes' => 'Файл аватара должен быть изображением формата jpeg, png или jpg.',
            'avatar.max' => 'Файл аватара не должен превышать 2 MB.',

            'email.required' => 'Поле "Электронная почта" обязательно для заполнения.',
            'email.email' => 'Введите действительный адрес электронной почты.',
            'email.unique' => 'Этот адрес электронной почты уже зарегистрирован.',

            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Поле "Имя" не может быть длиннее 255 символов.',

            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.string' => 'Поле "Телефон" должно быть строкой.',
            'phone.regex' => 'Поле "Телефон" должно быть в формате +7(999)999-99-99.',
            'phone.unique' => 'Этот номер телефона уже зарегистрирован.',

            'show_pennies.required' => 'Поле "Показывать копейки" обязательно для заполнения.',
            'show_pennies.in' => 'Поле "Показывать копейки" имеет неверный формат',

            'show_description.required' => 'Поле "Показывать описание" обязательно для заполнения.',
            'show_description.in' => 'Поле "Показывать описание" имеет неверный формат'
        ];
    }
}
