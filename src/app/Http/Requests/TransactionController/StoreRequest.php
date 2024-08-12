<?php

namespace App\Http\Requests\TransactionController;

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
            'group_id' => 'nullable|exists:transaction_categories,id',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:income,consumption',
            'type' => 'required|in:primary_activity,purchase_of_goods,basis_of_funds,fixed_assets,repayment_of_the_loan_body,withdrawal_of_profit,income_primary_activity,income_sale_of_fixed_assets,income_credit,income_putting_money',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название',
            'name.string' => 'Название должно быть строкой',
            'name.max' => 'Название не должно превышать 255 символов',

            'group_id.exists' => 'Указанной группы не существует',

            'description.string' => 'Описание должно быть строкой',
            'description.max' => 'Описание не должно превышать 1000 символов',

            'category.required' => 'Укажите категорию',
            'category.in' => 'Указана неверная категория',

            'type.required' => 'Укажите тип',
            'type.in' => 'Указан неверный тип'
        ];
    }
}
