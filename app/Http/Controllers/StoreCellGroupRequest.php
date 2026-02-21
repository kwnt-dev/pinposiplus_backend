<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCellGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hole_number' => 'required|integer|between:1,18',
            'comment' => 'nullable|string|max:255',
            'cells' => 'required|array|min:1',
            'cells.*.x' => 'required|integer',
            'cells.*.y' => 'required|integer',
        ];
    }
}
