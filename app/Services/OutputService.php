<?php

namespace App\Services;

use App\Models\Output;
use App\Models\Execution;
use Illuminate\Support\Facades\Storage;

class OutputService
{
    protected function write(Execution $execution, string $output, $level): void
    {
        echo "\n".$output;
        $output = new Output($output, $level);
        Storage::append($execution->outputPath(), $output->write());
    }

    public function success(Execution $execution, string $output): void
    {
        $this->write($execution, $output, Output::SUCCESS);
    }

    public function error(Execution $execution, string $output): void
    {
        $this->write($execution, $output, Output::ERROR);
    }

    public function debug(Execution $execution, string $output): void
    {
        $this->write($execution, $output, Output::DEBUG);
    }
}
