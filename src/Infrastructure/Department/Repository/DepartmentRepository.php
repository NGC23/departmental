<?php

declare(strict_types=1);

namespace App\Infrastructure\Department\Factory;

use App\Domain\Department\Contracts\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface {
    
    private array $data;

    public function __construct() {
        $this->data = [
            'department' => [
                'name' => 'test-1',
                'team' => [
                    'name' => 'test-team-1',
                    'staff' => [
                        [
                            'name' => 'test-1',
                            'position' => 'lead'
                        ],
                        [
                            'name' => 'test-2',
                            'position' => 'staff'
                        ],
                        [
                            'name' => 'test-3',
                            'position' => 'staff'
                        ]
                    ]
                ]
            ],
            'department' => [
                'name' => 'test-2',
                'team' => [
                    'name' => 'test-team-2',
                    'staff' => [
                        [
                            'name' => 'test-4',
                            'position' => 'lead'
                        ],
                        [
                            'name' => 'test-2',
                            'position' => 'staff'
                        ],
                        [
                            'name' => 'test-6',
                            'position' => 'staff'
                        ]
                    ]
                ]
            ]
        ];
    }

    public function getAll(): array
    {
        return $this->data;
    }
}