<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['bail', 'required', 'file', 'mimes:csv,txt,xls,xlsx', 'max:20000'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'The CSV file is required.',
            'file.file' => 'The uploaded file must be a valid CSV.',
            'file.mimes' => 'The file must be a CSV format (.csv or .txt).',
            'file.max' => 'The file size must not exceed 20MB.',
        ];
    }
}
