<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCellRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hole_number' => 'required|integer|between:1,18',
            'x' => 'required|integer',
            'y' => 'required|integer',
        ];
    }
}
