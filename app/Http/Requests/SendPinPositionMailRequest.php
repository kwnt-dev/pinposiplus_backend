<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendPinPositionMailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required|string',
            'pdf_url' => 'required|url',
            'to' => 'required|email',
        ];
    }
}
