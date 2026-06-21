<?php

namespace App\Http\Requests\Budgets;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetBudgetsRequest extends FormRequest
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
            'date' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O id é obrigatório',
            'id.exists' => 'Erro ao listar orçamentos',
            'date.required' => 'A data é obrigatória',
        ];
    }
}
