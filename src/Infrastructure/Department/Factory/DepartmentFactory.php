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
     * @throws DuplicateStaffMemberException
     */
    public function create(
        string $name, 
        Team $team,
        array $newStaffMembers
    ): Department {

        $oldStaffMembers = $team->getStaffMembers();

        if(count($newStaffMembers) > 0) {
            foreach($oldStaffMembers as $oldStaff) {
                foreach($newStaffMembers as $staffMember) {
                    if($oldStaff->getName() === $staffMember->getName()) {
                        throw new DuplicateStaffMemberException("Staff member {$staffMember->getName()} already exists!");
                    }
                }
            }
        }

        $staffMembers = array_merge($oldStaffMembers, $newStaffMembers);

        $team = $team->withStaffMembers($staffMembers);

        return new Department( 
            $name, 
            $team
        );
    }
}