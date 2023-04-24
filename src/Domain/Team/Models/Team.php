<?php

declare(strict_types=1);

namespace App\Domain\Team\Models;

class Team {
    public function __construct(
        private string $name, 
        private array $staffMembers
    ){
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * getStaffMembers()
     *
     * @return StaffMember[]
     */
    public function getStaffMembers(): array
    {
        return $this->staffMembers;
    }

    /**
     * withStaffMember() - this will add the new array of staff members to the clone, keeping the name and adding the new property and keeping the object immutable
     *
     * @param StaffMember[] $staffMembers
     * @return self
     */
    public function withStaffMembers(array $staffMembers): self
    {
        $clone = clone $this;
        $clone->staffMembers = $staffMembers;
        return $clone;
    }
}