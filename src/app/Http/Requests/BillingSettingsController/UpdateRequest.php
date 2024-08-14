<?php

namespace App\Http\Requests\BillingSettingsController;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'ceo_name' => 'nullable|string|max:255',
            'ceo_position' => 'nullable|string|max:255',
            'invoice_prefix' => 'nullable|string|max:255',
            'starting_number' => 'nullable|string|max:255',
            'stamp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'signature' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'ceo_name.string' => 'ФИО руководителя должно быть строкой.',
            'ceo_position.string' => 'Должность руководителя должна быть строкой.',
            'invoice_prefix.string' => 'Префикс должен быть строкой.',
            'starting_number.string' => 'Начальный номер должен быть строкой.',
            'stamp.image' => 'Файл с печатью должен быть изображением.',
            'stamp.mimes' => 'Файл с печатью должен быть формата jpg, jpeg или png.',
            'stamp.max' => 'Файл с печатью не должен превышать 2 МБ.',
            'signature.file' => 'Файл с подписью должен быть валидным файлом.',
            'signature.mimes' => 'Файл с подписью должен быть формата jpg, jpeg, png или pdf.',
            'logo.image' => 'Файл с логотипом должен быть изображением.',
            'logo.mimes' => 'Файл с логотипом должен быть формата jpg, jpeg или png.',
            'logo.max' => 'Файл с логотипом не должен превышать 2 МБ.',
        ];
    }
}
