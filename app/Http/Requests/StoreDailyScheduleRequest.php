<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date|unique:daily_schedules',
            'event_name' => 'nullable|string|max:255',
            'group_count' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ];
    }
}
