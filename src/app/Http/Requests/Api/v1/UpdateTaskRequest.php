<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'sometimes|required|string|max:255',
            'due_date' => 'sometimes|nullable|date',
            'status' => 'sometimes|required|in:Pendente,Em Andamento,Concluída,Cancelada',
            'tags' => 'nullable|string',
        ];
    }
}
