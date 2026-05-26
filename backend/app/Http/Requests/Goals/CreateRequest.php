<?php

namespace App\Http\Requests\Goals;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'id' => 'required|exists:users,use_id',
            'name' => 'required',
            'balance' => 'required',
            'balance_target' => 'required',
            'color' => 'required|in:ambar,esmeralda,azul,rosa,violeta'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O id é obrigatório',
            'id.exists' => 'Erro ao criar meta',
            'name.required' => 'O nome é obrigatório',
            'balance.required' => 'O valor atual é obrigatório',
            'balance_target.required' => 'O valor objetivo é obrigatório',
            'color.required' => 'A cor é obrigatória',
            'color.in' => 'A cor é inválida'
        ];
    }
}
