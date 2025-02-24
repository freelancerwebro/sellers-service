<?php

declare(strict_types=1);

return [
    'api' => [
        'title' => 'Laravel API Documentation',
        'description' => 'This is a generated API documentation using Swagger',
        'version' => '1.0.0',
        'generate_always' => true,
    ],
    'paths' => [
        'docs_json' => env('SWAGGER_JSON_URL', '/api/docs.json'),
        'docs_yaml' => storage_path('api-docs/api-docs.yaml'),
        'annotations' => base_path('app'),
    ],
    'constants' => [
        'L5_SWAGGER_TAGS' => [
            ['name' => 'CSV', 'description' => 'File upload operations'],
            ['name' => 'Sellers', 'description' => 'Seller-related operations'],
            ['name' => 'Sales', 'description' => 'Sales reports and transactions'],
        ],
    ],
];
