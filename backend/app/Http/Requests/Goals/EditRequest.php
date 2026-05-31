<?php

namespace App\Http\Requests\Goals;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'gls_id' => 'required|exists:goals,gls_id',
            'gls_name' => 'required',
            'gls_balance' => 'required',
            'gls_balance_target' => 'required',
            'gls_color' => 'required|in:ambar,esmeralda,azul,rosa,violeta'
        ];
    }

    public function messages(): array
    {
        return [
            'gls_id.required' => 'O id é obrigatório',
            'gls_id.exists' => 'Erro ao editar meta',
            'gls_name.required' => 'O nome é obrigatório',
            'gls_balance.required' => 'O valor atual é obrigatório',
            'gls_balance_target.required' => 'O valor objetivo é obrigatório',
            'gls_color.required' => 'A cor é obrigatória',
            'gls_color.in' => 'A cor é inválida'
        ];
    }
}
