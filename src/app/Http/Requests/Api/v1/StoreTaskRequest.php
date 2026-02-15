<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'status' => 'required|in:Pendente,Em Andamento,Concluída,Cancelada',
            'tags' => 'nullable|string',
        ];
    }
}
