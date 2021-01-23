<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Execution;
use App\Services\OutputService;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

trait ProcessRunner
{
    public function runProcess(
        Execution $execution,
        Process $process,
        OutputService $outputService,
        bool $displayTrace = false
    ): void {
        if ($displayTrace) {
            $this->displayTrace($execution, $process, $outputService);
        } else {
            $process->run();
        }

        if (!$process->isSuccessful()) {
            $outputService->error($execution, 'Process failed: '.$process->getOutput());
            throw new ProcessFailedException($process);
        }
    }

    protected function displayTrace(Execution $execution, Process $process, OutputService $outputService)
    {
        $process->start();

        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $outputService->debug($execution, 'STDOUT: '.$data);
            } else { // $process::ERR === $type
                $outputService->error($execution, 'STDERR: '.$data);
            }
        }
    }
}
