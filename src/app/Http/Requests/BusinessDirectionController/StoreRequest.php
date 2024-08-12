<?php

namespace App\Http\Requests\BusinessDirectionController;

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
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:business_directions,id',
            'position' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название направления обязательно для заполнения.',
            'name.string' => 'Название направления должно быть строкой.',
            'name.max' => 'Название направления не должно превышать 255 символов.',
            'parent_id.exists' => 'Выбранное родительское направление не существует.',
            'position.integer' => 'Позиция должна быть целым числом.',
            'position.min' => 'Позиция не может быть отрицательной.',
        ];
    }
}
