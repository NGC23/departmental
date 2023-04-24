<?php

declare(strict_types=1);

namespace App\Domain\Department\Models;

use App\Domain\Team\Models\Team;

class Department {
    public function __construct(
        private string $name, 
        private Team $team
    ){   
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function withTeam(Team $team): self
    {
        $clone = clone $this;
        $this->team = $team;
        return $clone;
    }
}