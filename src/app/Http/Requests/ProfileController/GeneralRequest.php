<?php

namespace App\Http\Requests\ProfileController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GeneralRequest extends FormRequest
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
        $date_formats = [
            'd.m.Y',
            'm.d.Y',
            'd/m/Y',
            'm/d/Y'
        ];

        $time_formats = [
            'H:i',
            'h:i A'
        ];

        return [
            'company_name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255|unique:users,subdomain',
            'currency_id' => ['required','string', 'exists:currencies,id'],
            'timezone_id' => 'required|exists:timezones,id',
            'date_format' => ['required', Rule::in($date_formats)],
            'time_format' => ['required', Rule::in($time_formats)]
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Поле "Название компании" обязательно для заполнения.',
            'company_name.string' => 'Поле "Название компании" должно быть строкой.',
            'company_name.max' => 'Поле "Название компании" не может быть длиннее 255 символов.',

            'subdomain.required' => 'Поле "Поддомен" обязательно для заполнения.',
            'subdomain.string' => 'Поле "Поддомен" должно быть строкой.',
            'subdomain.max' => 'Поле "Поддомен" не может быть длиннее 255 символов.',
            'subdomain.unique' => 'Такой поддомен уже существует.',

            'currency.required' => 'Поле "Валюта" обязательно для заполнения.',
            'currency.string' => 'Поле "Валюта" должно быть строкой.',
            'currency.in' => 'Выбранная валюта недействительна.',

            'timezone_id.required' => 'Поле "Часовой пояс" обязательно для заполнения.',
            'timezone_id.exists' => 'Выбранный часовой пояс не существует.',

            'date_format.required' => 'Поле "Формат даты" обязательно для заполнения.',
            'date_format.in' => 'Выбранный формат даты недействителен.',

            'time_format.required' => 'Поле "Формат времени" обязательно для заполнения.',
            'time_format.in' => 'Выбранный формат времени недействителен.',
        ];
    }
}
