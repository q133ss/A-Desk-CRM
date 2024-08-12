<?php

namespace App\Http\Requests\BankAccountController;

use App\Models\BankAccountGroup;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class AddGroupRequest extends FormRequest
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
            'group_id' => [
                'required',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    $group = BankAccountGroup::find($value);
                    if(!$group || $group->user_id != Auth('sanctum')->id())
                    {
                        $fail('Указана неверная группа');
                    }
                }
            ],
            'items' => 'required|array',
            'items.*' => 'required|exists:bank_accounts,id'
        ];
    }

    public function messages(): array
    {
        return [
            'group_id.required' => 'Укажите группу',
            'items.required' => 'Укажите счета',
            'items.array' => 'Счета должны быть массивом',
            'items.*.required' => 'Укажите счет',
            'items.*.exists' => 'Указан неверный счет'
        ];
    }
}
