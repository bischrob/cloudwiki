<?php

declare(strict_types=1);

return [
    'routes' => [
        [
            'name' => 'page#index',
            'url' => '/',
            'verb' => 'GET',
        ],
        [
            'name' => 'file_api#open',
            'url' => '/api/file',
            'verb' => 'GET',
        ],
        [
            'name' => 'file_api#save',
            'url' => '/api/file',
            'verb' => 'PUT',
        ],
    ],
];
