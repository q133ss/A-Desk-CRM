<?php

namespace App\Http\Requests\ProductController;

use App\Models\Product;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'type' => 'required|in:product,service',
            'name' => 'required|string|max:255',
            'sku' => [
                'nullable',
                'string',
                'max:255',
                function(string $attribute, mixed $value, Closure $fail): void
                {
                    $check = Product::where('user_id', Auth('sanctum')->id())
                        ->where('sku', $value)
                        ->exists();
                    if($check)
                    {
                        $fail('Продукт с таким артикулом уже есть');
                    }
                }
            ],
            'description' => 'nullable|string',
            'default_price' => 'nullable|numeric',
            'currency_id' => 'nullable|exists:currencies,id',
            'qty' => 'nullable|numeric',
            'date_of_receipt' => 'nullable|date_format:Y-m-d',
            'avg_price' => 'nullable|numeric',
            'entity_id' => 'nullable|exists:entities,id',

            // Проверка на заполнение всех полей или ни одного из последних 4-х
            'qty' => 'required_with:date_of_receipt,avg_price,entity_id|nullable|numeric',
            'date_of_receipt' => 'required_with:qty,avg_price,entity_id|nullable|date',
            'avg_price' => 'required_with:qty,date_of_receipt,entity_id|nullable|numeric',
            'entity_id' => 'required_with:qty,date_of_receipt,avg_price|nullable|exists:entities,id',

            'unit' => 'nullable|in:piece,gram,hectare,year,decimeter',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Тип обязателен.',
            'type.in' => 'Тип должен быть либо продуктом, либо услугой.',
            'name.required' => 'Название обязательно.',
            'sku.required' => 'Артикул обязателен.',
            'sku.unique' => 'Артикул должен быть уникальным.',
            'default_price.numeric' => 'Цена по умолчанию должна быть числом.',
            'currency_id.exists' => 'Выбранная валюта не существует.',
            'qty.numeric' => 'Количество должно быть числом.',
            'date_of_receipt.date_format' => 'Дата поступления должна быть допустимой датой.',
            'avg_price.numeric' => 'Средняя цена должна быть числом.',
            'entity_id.exists' => 'Выбранного юр. лица не существует.',

            'qty.required_with' => 'Количество обязательно, когда заполнены другие поля, связанные со складом.',
            'date_of_receipt.required_with' => 'Дата поступления обязательна, когда заполнены другие поля, связанные со складом.',
            'avg_price.required_with' => 'Средняя цена обязательна, когда заполнены другие поля, связанные со складом.',
            'entity_id.required_with' => 'Идентификатор сущности обязателен, когда заполнены другие поля, связанные со складом.',

            'unit.required' => 'Поле единицы измерения обязательно.',
            'unit.in' => 'Выбранная единица измерения недействительна. Допустимые значения: штука, грамм, гектар, год, дециметр.',
        ];

    }
}
