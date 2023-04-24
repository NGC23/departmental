<?php

declare(strict_types=1);

namespace Tests\Domain\Team\Models;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Domain\Staff\Models\StaffMemeber;
use App\Domain\Team\Models\Team;

final class TeamTest extends TestCase {

    public function testTeamCanBeCreated(): void 
    {
        $name1 = 'test1';
        $type1 = StaffMemeber::TYPE_STAFF_LEAD;

        $staffMember1 = new StaffMemeber($name1, $type1);

        $name2 = 'test2';
        $type2 = StaffMemeber::TYPE_STAFF_MEMBER;

        $staffMember2 = new StaffMemeber($name2, $type2);

        $staffMembers = [
            $staffMember1, 
            $staffMember2
        ];

        $team = new Team('test team', $staffMembers);

        $this->assertInstanceOf(Team::class, $team);
        $this->assertSame($name1, $staffMember1->getName());
        $this->assertSame($type2, $staffMember2->getType());
    }

    public function testCannotBeCreatedWithInvalidStaffMember(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $name1 = 'test1';
        $type1 = 'not valid';

        $staffMember1 = new StaffMemeber($name1, $type1);

        $name2 = 'test2';
        $type2 = StaffMemeber::TYPE_STAFF_MEMBER;

        $staffMember2 = new StaffMemeber($name2, $type2);

        $staffMembers = [
            $staffMember1, 
            $staffMember2
        ];

        $team = new Team('test team that will fail', $staffMembers);
    }

}