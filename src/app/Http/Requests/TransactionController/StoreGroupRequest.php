<?php

namespace App\Http\Requests\TransactionController;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            'name' => 'required|string',
            'category' => 'required|in:income,consumption'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название',
            'name.string' => 'Название должно быть строкой',

            'category.required' => 'Укажите категорию',
            'category.in' => 'Указана неверная категория'
        ];
    }
}
