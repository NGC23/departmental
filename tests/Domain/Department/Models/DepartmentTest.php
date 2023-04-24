<?php

declare(strict_types=1);

namespace Tests\Domain\Department\Models;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Domain\Team\Models\Team;
use App\Domain\Staff\Models\StaffMemeber;
use App\Domain\Department\Models\Department;

final class DepartmentTest extends TestCase {

    public function testDepartmentCanBeCreated(): void 
    {
        $name = 'test1';
        $type = StaffMemeber::TYPE_STAFF_LEAD;

        $staffMember = new StaffMemeber($name, $type);

        $team = new Team('test team', [$staffMember]);

        $department = new Department('test department', $team);

        $this->assertInstanceOf(Department::class, $department);
    }

    public function testDepartmentCannotBeCreatedWithInvalidStaffMemberType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $name = 'test1';
        $type = 'not valid';

        $staffMember = new StaffMemeber($name, $type);

        $team = new Team('test team', [$staffMember]);

        new Department('test department', $team);
    }
}