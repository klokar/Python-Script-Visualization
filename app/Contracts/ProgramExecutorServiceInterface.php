<?php

namespace App\Contracts;

use App\Models\Execution;

interface ProgramExecutorServiceInterface
{
    public function getExecutable(): string;

    public function prepare(Execution $execution, bool $displayTrace = false): void;

    public function clear(Execution $execution, bool $displayTrace = false): void;

    public function requirementsBasePath(): string;
}
