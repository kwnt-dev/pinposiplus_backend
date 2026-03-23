<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePinSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course' => 'required|in:OUT,IN',
            'target_date' => 'nullable|date',
            'event_name' => 'nullable|string',
            'groups_count' => 'nullable|integer',
            'is_rainy' => 'nullable|boolean',
        ];
    }
}
