<?php

namespace App\Http\Requests\Budgets;

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
            'bdt_id' => 'required|exists:budgets,bdt_id',
            'bdt_name' => 'required',
            'bdt_color' => 'required|in:ambar,rosa,violeta,esmeralda,azul',
            'bdt_limit' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'bdt_id.required' => 'O id é obrigatório',
            'ibdt_idd.exists' => 'Erro ao editar orçamento',
            'bd_name.required' => 'O nome é obrigatório',
            'bdt_limit.required' => 'O limite é obrigatório',
            'bdt_color.required' => 'A cor é obrigatória',
            'bdt_color.in' => 'A cor é inválida'
        ];
    }
}
