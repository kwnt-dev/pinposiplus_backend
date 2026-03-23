<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePinSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_name' => 'nullable|string',
            'groups_count' => 'nullable|integer',
            'status' => 'nullable|in:draft,published,confirmed,sent',
        ];
    }
}
