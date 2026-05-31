<?php

namespace App\Http\Requests\Goals;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class DeleteRequest extends FormRequest
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
            'id' => 'required|exists:goals,gls_id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O id é obrigatório',
            'id.exists' => 'Erro ao excluir meta',
        ];
    }
}
