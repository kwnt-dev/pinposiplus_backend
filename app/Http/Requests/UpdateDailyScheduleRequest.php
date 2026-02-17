<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'sometimes|date|unique:daily_schedules,date,'.$this->route('id'),
            'event_name' => 'sometimes|string|max:255',
            'group_count' => 'sometimes|integer|min:1',
            'notes' => 'nullable|string',
        ];
    }
}
