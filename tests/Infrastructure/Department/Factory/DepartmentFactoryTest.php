<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Department\Factory;

use PHPUnit\Framework\TestCase;
use App\Domain\Team\Models\Team;
use App\Domain\Staff\Models\StaffMemeber;
use App\Domain\Department\Models\Department;
use App\Infrastructure\Department\Factory\DepartmentFactory;
use App\Domain\Staff\Exceptions\DuplicateStaffMemberException;

final class DepartmentFactoryTest extends TestCase {

    private Department $factoryResult;

    protected function setup(): void
    {        
        $name = 'test1';
        $type = StaffMemeber::TYPE_STAFF_LEAD;

        $staffMember = new StaffMemeber($name, $type);

        $team = new Team('test team', [$staffMember]);

        $departmentFactory = new DepartmentFactory();

        // $this->mockObj = $this->getMockBuilder(DepartmentFactory::class)->setConstructorArgs(array(true))->getMock();
        $this->factoryResult = $departmentFactory->create('test department factory', $team, []);
    }

    public function testDepartmentCanBeCreatedWithNoNewTeamMembers(): void 
    {
        $this->assertInstanceOf(Department::class, $this->factoryResult);
    }

    public function testDepartmentFactoryThrowsExceptionOnDuplicateStaffMember(): void
    {
        $this->expectException(DuplicateStaffMemberException::class);

        $name = 'test1';
        $type = StaffMemeber::TYPE_STAFF_LEAD;

        $staffMember = new StaffMemeber($name, $type);

        $team = new Team('test team', [$staffMember]);

        $departmentFactory = new DepartmentFactory();

        // add the same staff member to see if we can create a department with duplicate team members or it throws exception as expected
        $departmentFactory->create('test department factory with duplicate member', $team, [$staffMember]);
    }
}