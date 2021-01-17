<?php

namespace App\Services;

use Exception;
use App\Models\Output;
use App\Models\Execution;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExecutionService
{
    public function createAndRun(
        int $processorId,
        int $datasetId,
        int $datasetEvaluationId,
        int $testSetSize,
        ?string $comment,
        ?string $parameters,
        bool $displayTrace = false
    ): void
    {
        try {
            $execution = $this->create($processorId, $datasetId, $datasetEvaluationId, $testSetSize, $comment, $parameters);
            $this->run($execution, $displayTrace);

        } catch (Exception $e) {
            logger()->error($e);
        }
    }

    /**
     * @param int         $processorId
     * @param int         $datasetId
     * @param int         $datasetEvaluationId
     * @param int         $testSetSize
     * @param string|null $comment
     * @param string|null $parameters
     *
     * @return Execution
     * @throws Exception
     */
    public function create(
        int $processorId,
        int $datasetId,
        int $datasetEvaluationId,
        int $testSetSize,
        ?string $comment,
        ?string $parameters
    ): Execution
    {
        return Execution::create([
            'hash' => bin2hex(random_bytes(16)),
            'data_processor_id' => $processorId,
            'dataset_id' => $datasetId,
            'dataset_ev_id' => $datasetEvaluationId,
            'test_set_size' => $testSetSize,
            'comment' => $comment,
            'parameters' => $parameters,
        ]);
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

    protected function writeOutput(Execution $execution, string $output, $level = Output::DEBUG): void
    {
        echo "\n".$output;
        $output = new Output($output, $level);
        Storage::append($execution->outputPath(), $output->write());
    }

    protected function deleteExecutionDir(Execution $execution): void
    {
        // Delete old execution dir
        Storage::deleteDirectory($execution->basePath());
        $this->writeOutput($execution, 'Created directory: '.$execution->basePath());
    }

    protected function createVirtualEnvironment(Execution $execution, bool $displayTrace = false): void
    {
        $process = new Process([
            'python3',
            '-m',
            'venv',
            $execution->venvPath(),
        ]);
        $this->runProcess($execution, $process, $displayTrace);
        $this->writeOutput($execution, 'Created python virtual environment: '.$execution->venvPath());

        // Update pip as some requirements need latest version
        $process = new Process([
            $execution->pipPath(),
            'install',
            '--upgrade',
            'pip',
            'setuptools',
        ]);
        $this->runProcess($execution, $process, $displayTrace);
        $this->writeOutput($execution, 'Upgraded pip and setuptools');
    }

    protected function runProcess(Execution $execution, Process $process, bool $displayTrace = false): void
    {
        if ($displayTrace) {
            $this->displayTrace($execution, $process);
        } else {
            $process->run();
        }

        if (!$process->isSuccessful()) {
            $this->writeOutput($execution, 'Process failed: '.$process->getOutput(), Output::ERROR);
            throw new ProcessFailedException($process);
        }
    }

    protected function displayTrace(Execution $execution, Process $process)
    {
        $process->start();

        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                $this->writeOutput($execution, 'STDOUT: '.$data);
            } else { // $process::ERR === $type
                $this->writeOutput($execution, 'STDERR: '.$data, Output::ERROR);
            }
        }
    }

    protected function prepareStorage(Execution $execution)
    {
        // Processor
        Storage::put($execution->processorPath(), Storage::get($execution->dataProcessor->path));

        // Datasets
        Storage::put($execution->datasetPath(), Storage::get($execution->dataset->path));
        Storage::put($execution->datasetEvPath(), Storage::get($execution->datasetEv->path));

        // Result directories
        Storage::makeDirectory($execution->resultFiguresPath());
        Storage::makeDirectory($execution->resultDataPath());

        $this->writeOutput($execution, 'Storage prepared: '.implode(',', Storage::directories($execution->basePath(), true)));
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
        $this->runProcess($execution, $process, $displayTrace);

        $this->writeOutput($execution, 'Requirements handled: '.$requirementsPath);
    }

    public function execute(Execution $execution, bool $displayTrace = false, int $timeout = 5): void
    {
        $commands = [
            $execution->pythonPath(),
            $execution->processorShortPath(),
            '-i',
            $execution->datasetShortPath(),
            '-o',
            $execution->datasetEvShortPath(),
            $execution->executionShortPath(),
            $execution->resultFiguresShortPath(),
            $execution->resultDataShortPath(),
            $execution->dataProcessor->level,
            $execution->test_set_size,
        ];

        if (!empty($execution->parameters)) {
            foreach (explode(',', $execution->parameters) as $parameter) {
                if (strpos($parameter, '=') !== false) { // test=123
                    $commands = array_merge($commands, explode('=', $parameter));
                } else {
                    $commands[] = $parameter;
                }
            }
        }

        $process = new Process($commands);
        $process->setWorkingDirectory($execution->storagePath());
        $process->setTimeout(60 * $timeout);
        $this->runProcess($execution, $process, $displayTrace);

        $this->writeOutput($execution, 'Execution complete: '.implode(',', $commands), Output::SUCCESS);
    }

    public function disconnectVirtualEnvironment(Execution $execution, bool $displayTrace = false): void
    {
        try {
            $process = new Process([
                'rm',
                '-rf',
                $execution->venvPath(),
            ]);
            $this->runProcess($execution, $process, $displayTrace);
            $this->writeOutput($execution, 'Disconnected python virtual environment');
        } catch (Exception $e) {
            $this->writeOutput($execution, 'Disconnected python virtual environment', Output::ERROR);
        }
    }
}
