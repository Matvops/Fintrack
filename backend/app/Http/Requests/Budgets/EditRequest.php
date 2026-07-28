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
            'id' => 'required|exists:budgets,bdt_id',
            'name' => 'required',
            'color' => 'required|in:ambar,rosa,violeta,esmeralda,azul',
            'limit' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O id é obrigatório',
            'id.exists' => 'Erro ao editar orçamento',
            'name.required' => 'O nome é obrigatório',
            'limit.required' => 'O limite é obrigatório',
            'color.required' => 'A cor é obrigatória',
            'color.in' => 'A cor é inválida'
        ];
    }
}
