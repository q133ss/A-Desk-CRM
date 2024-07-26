<?php

namespace App\Http\Requests\AuthController;

use App\Models\User;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                function(string $attribute, mixed $value, Closure $fail){
                    $user = User::where('email', $this->email);
                    if(!$user->exists() || !Hash::check($value, $user->pluck('password')->first())){
                        $fail('Неверный email или пароль');
                    }
                }
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Поле "Email" должно быть действительным адресом электронной почты.',
            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.string' => 'Поле "Пароль" должно быть строкой.'
        ];
    }
}
