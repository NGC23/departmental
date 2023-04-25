<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Domain\Team\Models\Team;
use App\Domain\Staff\Models\StaffMemeber;
use App\Domain\Department\Models\Department;
use App\Infrastructure\Department\Factory\DepartmentFactory;
use App\Domain\Staff\Exceptions\DuplicateStaffMemberException;
use App\Infrastructure\Department\Repository\DepartmentRepository;

//PLEASE NOTE: If i had used controllers, routing and Dependency injection i would not be instantiating concrete classes anywhere in my codebase
$departmentData = (new DepartmentRepository())->getAll();
//Should be interfaced
$factory = new DepartmentFactory();
//To Add Data please just set department name and add StaffMember to staff array, please note we can only add for one department at a time for now
$newStaffMembers = [
    'department' => [
        'name' => 'test-2', //Change departmetn here
        'staff' => [ // Add StaffMember Objects here
            new StaffMemeber('test-22', StaffMemeber::TYPE_STAFF_MEMBER),
            new StaffMemeber('test-11', StaffMemeber::TYPE_STAFF_MEMBER),
            new StaffMemeber('test-12', StaffMemeber::TYPE_STAFF_MEMBER),
        ]
    ]
];
// Some old school error capturing, i do not have a logger and dont want to do any over kill things here, just show basic principles
$errors = [];

//Passing values by exception is not usually something i do, but this was to indicate errors
//What we do here, we just gather the data and form it into value objects passing it onto the factory where all logic lies to build a valid department
$departmentInformation = array_map(
    function(array $departmentData) use(
        $factory, 
        $newStaffMembers, 
        &$errors
    ) : ?Department {
    $leadNeeded = false;
    $staffMembers = [];

    if(!empty($departmentData['department']['team']['name'])) {
        $team = new Team(
            $departmentData['department']['team']['name'],
            []
        );
    }

    if(!empty($departmentData['department']['team']['staff'])) {
        if(count($departmentData['department']['team']['staff']) > 1) {
            $leadNeeded = true;
        }

        foreach($departmentData['department']['team']['staff'] as $key => $staff) {
            if($leadNeeded && (int) $key === 0) {
                $staffMembers[] = new StaffMemeber(
                    $staff['name'], 
                    StaffMemeber::TYPE_STAFF_LEAD
                );
                continue;
            }
            $staffMembers[] = new StaffMemeber(
                $staff['name'], 
                StaffMemeber::TYPE_STAFF_MEMBER
            );
        }   
    }

    //Add original staff to team for factory to take valid Team VO
    $team = $team->withStaffMembers($staffMembers);

    if(!$team instanceof Team) {
        $errors[] = "Team is not valid for department {$departmentData['department']['name']}";
    }

    //lets build the department with an empty team for now
    try {
        return $factory->create(
            $departmentData['department']['name'], 
            $team, 
            ($departmentData['department']['name'] === $newStaffMembers['department']['name']) ? $newStaffMembers['department']['staff'] : [] //Only add staff members if department name correlates
        );
    // Not great exception handeling but displaying i know how to, i would in duplicate case reurn a 409 with json response from Application level - COntroller
    } catch(DuplicateStaffMemberException | Exception $e) {
        $errors[] = $e->getMessage() . PHP_EOL;
    }
    
    $errors[] = "Error creating Department - {$departmentData['department']['name']} - please see previous error";

    return null;

}, $departmentData);

if(!empty($errors)) {
    echo "<pre>";
    print_r($errors);
    echo "<hr>";
}

echo "<pre>"; 
print_r($departmentInformation); 
die('Please see department list');

