<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:50|min:1',
            'email' => 'required|email|unique:users,use_email',
            'password' => 'required',
            'confirmationPassword' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'password.required' => 'A senha é obrigatória',
            'confirmationPassword.required' => 'A confirmação de senha é obrigatória',
            'name.min' => 'O nome deve conter no mínimo :min dígitos',
            'name.max' => 'O nome deve conter no máximo :max dígitos',
            'email.email' => 'Email inválido',
            'email.unique' => 'Email indisponível',
            'confirmationPassword.same' => 'Senhas são diferentes'
        ];
    }
}
