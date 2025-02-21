<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadFileRequest extends FormRequest
{
    const EXPECTED_COLUMNS = [
        'uuid',
        'seller_id',
        'seller_firstname',
        'seller_lastname',
        'date_joined',
        'country',
        'contact_region',
        'contact_date',
        'contact_customer_fullname',
        'contact_type',
        'contact_product_type_offered_id',
        'contact_product_type_offered',
        'sale_net_amount',
        'sale_gross_amount',
        'sale_tax_rate',
        'sale_product_total_cost',
    ];

    public function rules(): array
    {
        return [
            'file' => ['bail', 'required', 'file', 'mimes:csv,txt', 'max:20000'],
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $file = $this->file('file');

            if (!$file) {
                $validator->errors()->add('file', 'No file uploaded.');
                return;
            }

            $handle = fopen($file->getPathname(), "r");
            $headers = fgetcsv($handle);

            if (!is_array($headers)) {
                $validator->errors()->add('file', 'The uploaded file is empty.');
                return;
            }

            if (count($headers) !== count(self::EXPECTED_COLUMNS)) {
                $validator->errors()->add(
                    'file',
                    "Invalid number of columns. Expected: " . implode(', ', self::EXPECTED_COLUMNS) .
                    " but found " . count($headers) . " columns."
                );
            }

            if ($headers !== self::EXPECTED_COLUMNS) {
                $validator->errors()->add(
                    'file',
                    "Invalid column names. Expected: " . implode(', ', self::EXPECTED_COLUMNS) .
                    " but found: " . implode(', ', $headers)
                );
            }

            fclose($handle);
        });
    }
}
