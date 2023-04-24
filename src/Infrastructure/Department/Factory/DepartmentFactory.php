<?php

declare(strict_types=1);

namespace App\Infrastructure\Department\Factory;

use App\Domain\Team\Models\Team;
use App\Domain\Staff\Models\StaffMemeber;
use App\Domain\Department\Models\Department;
use App\Domain\Staff\Exceptions\DuplicateStaffMemberException;

class DepartmentFactory {
    public function __construct() {}

    /**
     * factory for Department, should be static, but i want to use DI container to inject into classes rather
     *
     * @param string $name
     * @param Team $team
     * @param StaffMember[] $newStaffMembers
     * @return Department
     */
    public function create(
        string $name, 
        Team $team,
        array $newStaffMembers
    ): Department {

        $oldStaffMembers = $team->getStaffMembers();

        $staffMembers[] = array_map(function(StaffMemeber $staff) use ($newStaffMembers){
            foreach($newStaffMembers as $staffMember) {
                if($staffMember->getName() === $staff->getName()) {
                    throw new DuplicateStaffMemberException("Staff member {$staff->getName()} already exists!");
                }
                return new StaffMemeber(
                    $staffMember->getName(), 
                    $staffMember->getType()
                );
            }
        },  $oldStaffMembers);

        $team = $team->withStaffMembers($staffMembers);

        return new Department( 
            $name, 
            $team
        );

    }
}