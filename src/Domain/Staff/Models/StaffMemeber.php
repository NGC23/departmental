<?php

declare(strict_types=1);

namespace App\Domain\Staff\Models;

use InvalidArgumentException;

class StaffMemeber {
    public const TYPE_STAFF_MEMBER = 'staff';
    public const TYPE_STAFF_LEAD = 'lead';

    public function __construct(
        private string $name, 
        private string $type
    ){
        if(!in_array(
                $this->type, 
                [
                    self::TYPE_STAFF_LEAD, 
                    self::TYPE_STAFF_MEMBER
                ]
            )
        ) {
            throw new InvalidArgumentException("Invalid type - {$this->type}, please provide only type: {self::TYPE_STAFF_LEAD}, {self::TYPE_STAFF_MEMBER}");
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function withType(string $type): self
    {
        $clone = clone $this;
        $clone->type = $type;
        return $clone;
    }
}