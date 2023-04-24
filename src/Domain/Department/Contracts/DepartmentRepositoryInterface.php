<?php

declare(strict_types=1);

namespace App\Domain\Department\Contracts;

interface DepartmentRepositoryInterface {

    /**
     * getAll Departments and information tied
     *
     * @return array
     */
    public function getAll(): array;
}