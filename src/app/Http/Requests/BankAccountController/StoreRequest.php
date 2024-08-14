<?php

namespace App\Http\Requests\BankAccountController;

use App\Models\Entity;
use App\Models\TransactionItem;
use Closure;
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'group_id' => 'nullable|exists:bank_account_groups,id',
            'entity_id' => [
                'required',
                'exists:entities,id',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    $entity = Entity::findOrFail($value);
                    if($entity->user_id != Auth('sanctum')->id())
                    {
                        $fail('Указанное юр. лицо принадлежит не вам');
                    }
                }
            ],
            'bank' => 'nullable|string|max:255',
            'bik' => 'nullable|string|max:255',
            'ks' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'currency_id' => 'required|exists:currencies,id',
            'commission_article_id' => [
                'nullable',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    $check = TransactionItem::where('user_id', Auth('sanctum')->id())
                        ->where('id', $value)
                        ->exists();

                    if(!$check)
                    {
                        $fail('Указана неверная статья комиссии');
                    }
                }
            ],
            'return_clause_id' => [
                'nullable',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    $check = TransactionItem::where('user_id', Auth('sanctum')->id())
                        ->where('id', $value)
                        ->exists();

                    if(!$check)
                    {
                        $fail('Указана неверная статья возврата');
                    }
                }
            ],
            'initial_amount' => [
                'nullable',
                'numeric',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    if($this->date == null && $value != null)
                    {
                        $fail('Укажите дату');
                    }
                }
            ],
            'date' => [
                'nullable',
                'date',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    if($this->initial_amount != null && $value == null)
                    {
                        $fail('Укажите дату');
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.string' => 'Поле "Имя" должно быть строкой.',
            'name.max' => 'Поле "Имя" не должно превышать 255 символов.',
            'group_id.exists' => 'Выбранная группа не существует.',
            'entity_id.required' => 'Поле "Юр лицо" обязательно для заполнения.',
            'entity_id.exists' => 'Выбранное юр лицо не существует.',
            'bank.string' => 'Поле "Название банка" должно быть строкой.',
            'bank.max' => 'Поле "Название банка" не должно превышать 255 символов.',
            'bik.string' => 'Поле "БИК" должно быть строкой.',
            'bik.max' => 'Поле "БИК" не должно превышать 255 символов.',
            'ks.string' => 'Поле "К/с" должно быть строкой.',
            'ks.max' => 'Поле "К/с" не должно превышать 255 символов.',
            'number.string' => 'Поле "Номер счета" должно быть строкой.',
            'number.max' => 'Поле "Номер счета" не должно превышать 255 символов.',
            'currency_id.required' => 'Поле "Валюта" обязательно для заполнения.',
            'currency_id.exists' => 'Указанно неверное значение в поле "Валюта"',
            'commission_article_id.exists' => 'Выбранная статья комиссии не существует.',
            'return_clause_id.exists' => 'Выбранная статья возврата не существует.',
            'initial_amount.numeric' => 'Поле "Начальный остаток" должно быть числом.',
            'date.date' => 'Поле "Дата" должно быть корректной датой.',
        ];
    }
}
