<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetSalesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'year' => $this->route('year'),
        ]);
    }
}