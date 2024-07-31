<?php

namespace App\Http\Requests\EntityController;

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
            'entity_name' => 'required|string',
            'full_name' => 'required|string',
            'inn' => 'required|string',
            'kpp' => 'required|string',
            'ogrn' => 'required|string',
            'ur_address' => 'required|string',
            'phone' => 'required|string|regex:/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
            'with_nds' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'entity_name.required' => 'Поле "Название юридического лица" обязательно для заполнения.',
            'entity_name.string' => 'Поле "Название юридического лица" должно быть строкой.',
            'full_name.required' => 'Поле "Полное название юр.лица" обязательно для заполнения.',
            'full_name.string' => 'Поле "Полное название юр.лица" должно быть строкой.',
            'inn.required' => 'Поле "ИНН" обязательно для заполнения.',
            'inn.string' => 'Поле "ИНН" должно быть строкой.',
            'kpp.required' => 'Поле "КПП" обязательно для заполнения.',
            'kpp.string' => 'Поле "КПП" должно быть строкой.',
            'ogrn.required' => 'Поле "ОГРН" обязательно для заполнения.',
            'ogrn.string' => 'Поле "ОГРН" должно быть строкой.',
            'ur_address.required' => 'Поле "Юридический адрес" обязательно для заполнения.',
            'ur_address.string' => 'Поле "Юридический адрес" должно быть строкой.',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.string' => 'Поле "Телефон" должно быть строкой.',
            'phone.regex' => 'Поле "Телефон" должно быть в формате +7(999)-999-99-99.',
            'phone.max' => 'Поле "Телефон" не может быть длиннее 255 символов.',
            'with_nds.required' => 'Поле "Юридическое лицо работает с НДС" обязательно для заполнения.',
            'with_nds.boolean' => 'Поле "Юридическое лицо работает с НДС" должно быть булевым значением.',
        ];
    }

}
