<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Execution;
use App\Traits\ProcessRunner;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class ExecutionService
{
    use ProcessRunner;

    protected $out;
    protected $executor;

    public function __construct(OutputService $outputService, PythonService $pythonService)
    {
        $this->out = $outputService;
        $this->executor = $pythonService;
    }

    /**
     * @param User        $user
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
        User $user,
        int $processorId,
        int $datasetId,
        int $datasetEvaluationId,
        int $testSetSize,
        ?string $comment,
        ?string $parameters
    ): Execution
    {
        $execution = new Execution([
            'hash' => bin2hex(random_bytes(16)),
            'data_processor_id' => $processorId,
            'dataset_id' => $datasetId,
            'dataset_ev_id' => $datasetEvaluationId,
            'test_set_size' => $testSetSize,
            'comment' => $comment,
            'parameters' => $parameters,
            'status' => Execution::STATUS_CREATED,
        ]);

        $user->executions()->save($execution);

        return $execution;
    }

    public function run(Execution $execution, bool $displayTrace = false): void
    {
        try {
            $execution->setStatus(Execution::STATUS_STARTED);

            $this->deleteExecutionDir($execution);
            $this->executor->prepare($execution, $displayTrace);
            $this->prepareStorage($execution);
            $this->execute($execution, $displayTrace);

            $this->out->success($execution, 'COMPLETED: '.Carbon::now()->toDateTimeString());
            $execution->setStatus(Execution::STATUS_COMPLETE);
        } catch (Exception $e) {
            logger()->error($e);
            $this->out->error($execution, 'ERROR: '.$e->getMessage());
            $execution->setStatus(Execution::STATUS_ERROR);
        }
    }

    protected function deleteExecutionDir(Execution $execution): void
    {
        // Delete old execution dir
        Storage::deleteDirectory($execution->basePath());
        $this->out->success($execution, 'STARTED: '.Carbon::now()->toDateTimeString());
        $this->out->success($execution, 'Created directory: '.$execution->basePath());
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

        foreach (Storage::directories($execution->executionPath(), true) as $directory) {
            $this->out->debug(
                $execution,
                'CREATED: '.$directory
            );
        }

        $this->out->success(
            $execution,
            'Storage prepared: '.$execution->executionPath()
        );
    }

    public function execute(Execution $execution, bool $displayTrace = false, int $timeout = 5): void
    {
        $commands = [
            $this->executor->getExecutable(),
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
        $this->runProcess($execution, $process, $this->out, $displayTrace);

        $this->out->success($execution, 'Execution complete: '.implode(' ', $commands));
    }
}
