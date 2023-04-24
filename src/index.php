<?php

declare(strict_types=1);

use App\Infrastructure\Department\Factory\DepartmentRepository;

//PLEASE NOTE: If i had used controllers, routing and Dependency injection i would not be instantiating concrete classes anywhere in my codebase
$departmentData = (new DepartmentRepository())->getAll();

$departmentInformation = array_map(function(array $department){

}, $departmentInformation);