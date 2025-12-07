<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,normal,urgent'],
            'due' => ['nullable', 'date'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert empty string to null for nullable fields
        if ($this->has('due') && $this->due === '') {
            $this->merge(['due' => null]);
        }
        if ($this->has('project_id') && $this->project_id === '') {
            $this->merge(['project_id' => null]);
        }
    }
}

