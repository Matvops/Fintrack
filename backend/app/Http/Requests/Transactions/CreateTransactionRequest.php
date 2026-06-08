<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'type' => 'required|in:expense,income',
            'description' => 'required',
            'value' => 'required',
            'date' => 'required|date',
            'category' => 'required_if:type,expense|exists:budgets,bdt_id'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O id é obrigatório',
            'id.exists' => 'Erro ao criar transação',
            'type.required' => 'O tipo é obrigatório',
            'type.in' => 'Tipo de transação inválido',
            'category.required' => 'A categoria é obrigatória',
            'category.exists' => 'Categoria inválida',
            'date.required' => 'A data é obrigatória',
            'date.date' => 'Data inválida',
            'value.required' => 'O valor é obrigatório',
            'description.required' => 'A descrição é obrigatória',
        ];
    }
}
