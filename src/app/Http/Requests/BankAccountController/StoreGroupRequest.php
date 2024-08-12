<?php

namespace App\Http\Requests\BankAccountController;

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
            'name' => 'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название',
            'name.string' => 'Название группы должно быть строкой',
            'name.max' => 'Название группы не должно превышать 255 символов'
        ];
    }
}
