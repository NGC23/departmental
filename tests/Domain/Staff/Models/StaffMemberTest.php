<?php

declare(strict_types=1);

namespace Tests\Domain\Staff\Models;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Domain\Staff\Models\StaffMemeber;

final class StaffMemberTest extends TestCase {

    public function testStaffMemberCanBeCreated(): void 
    {
        $name = 'test1';
        $type = StaffMemeber::TYPE_STAFF_LEAD;

        $staffMember = new StaffMemeber($name, $type);

        $this->assertInstanceOf(StaffMemeber::class, $staffMember);
    }

    public function testCannotBeCreatedWithInvalidProperties(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $name = 'test1';
        $type = 'not valid';

        new StaffMemeber($name, $type);
    }

    public function testStaffMemberTypeCanBeChanged(): void
    {
        $name = 'test1';
        $type = StaffMemeber::TYPE_STAFF_MEMBER;

        $staffMember = new StaffMemeber($name, $type);
        $staffMember = $staffMember->withType(StaffMemeber::TYPE_STAFF_LEAD);

        $this->assertInstanceOf(StaffMemeber::class, $staffMember);
        $this->assertSame(StaffMemeber::TYPE_STAFF_LEAD, $staffMember->getType());
    }

}