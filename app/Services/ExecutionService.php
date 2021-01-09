<?php

namespace App\Services;

use Exception;
use App\Models\Execution;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExecutionService
{
    public function createAndRun(int $processorId, int $datasetId, ?string $comment, ?string $parameters, bool $displayTrace = false): void
    {
        try {
            $execution = $this->create($processorId, $datasetId, $comment, $parameters);
            $this->run($execution, $displayTrace);

        } catch (Exception $e) {
            logger()->error($e);
        }
    }

    /**
     * @param int         $processorId
     * @param int         $datasetId
     * @param string|null $comment
     * @param string|null $parameters
     *
     * @return Execution
     * @throws Exception
     */
    protected function create(int $processorId, int $datasetId, ?string $comment, ?string $parameters): Execution
    {
        return Execution::create([
            'hash' => bin2hex(random_bytes(16)),
            'data_processor_id' => $processorId,
            'dataset_id' => $datasetId,
            'comment' => $comment,
            'parameters' => $parameters,
        ]);
    }

    protected function createVirtualEnvironment(Execution $execution, bool $displayTrace = false): void
    {
        $process = new Process([
            'python3',
            '-m',
            'venv',
            $execution->venvPath()
        ]);
        $this->runProcess($process, $displayTrace);

        // Update pip as some requirements need latest version
        $process = new Process([
            $execution->pipPath(),
            'install',
            '--upgrade',
            'pip',
            'setuptools'
        ]);
        $this->runProcess($process, $displayTrace);
    }

    public function disconnectVirtualEnvironment(Execution $execution, bool $displayTrace = false): void
    {
        try {
            $process = new Process([
                'rm',
                '-rf',
                $execution->venvPath()
            ]);
            $this->runProcess($process, $displayTrace);
        } catch (Exception $e){}
    }

    protected function deleteExecutionDir(Execution $execution): void
    {
        // Delete old execution dir
        Storage::deleteDirectory($execution->shortPath());
    }

    protected function prepareStorage(Execution $execution)
    {
        // Processor
        Storage::put($execution->processorPath(), Storage::get($execution->dataProcessor->path));

        // Dataset
        Storage::put($execution->datasetPath(), Storage::get($execution->dataset->path));
    }

    public function prepareRequirements(Execution $execution, bool $displayTrace = false, int $timeout = 15)
    {
        // Storage dir should be owned by root:root - chown -R root:root storage/
        $cachePath = storage_path('app/dependencies/cache');
        $requirementsPath = storage_path('app/dependencies/requirements.txt');

        // If want to copy dependencies to current dir add '-t', './',
        $process = new Process([
            $execution->pipPath(),
            'install',
            '--cache-dir',
            $cachePath,
            '-r',
            $requirementsPath,
            '--disable-pip-version-check',
        ]);

        $process->setWorkingDirectory($execution->storagePath());
        $process->setTimeout(60 * $timeout);
        $this->runProcess($process, $displayTrace);
    }

    protected function runProcess(Process $process, bool $displayTrace = false): void
    {
        if ($displayTrace) {
            $this->displayTrace($process);
        } else {
            $process->run();
        }

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    public function execute(Execution $execution, bool $displayTrace = false, int $timeout = 5): void
    {
        $process = new Process([
            $execution->pythonPath(),
            $execution->dataProcessor->filename,
        ]);

        $process->setWorkingDirectory($execution->storagePath());
        $process->setTimeout(60 * $timeout);
        $this->runProcess($process, $displayTrace);
    }

    public function run(Execution $execution, bool $displayTrace = false): void
    {
        try {
            $this->deleteExecutionDir($execution);
            $this->createVirtualEnvironment($execution, $displayTrace);
            $this->prepareStorage($execution);
            $this->prepareRequirements($execution, $displayTrace);
            $this->execute($execution, $displayTrace);

        } catch (Exception $e) {
            logger()->error($e);
        } finally {
            $this->disconnectVirtualEnvironment($execution);
        }
    }

    protected function displayTrace(Process $process) {
        $process->start();

        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                echo "\nRead from stdout: " . $data;
            } else { // $process::ERR === $type
                echo "\nRead from stderr: " . $data;
            }
        }
    }
}
