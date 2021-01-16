<?php

namespace App\Console\Commands;

use App\Models\Execution;
use Illuminate\Console\Command;
use App\Services\ExecutionService;

class RunExecution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execution:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs specified execution';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ExecutionService $executionService
     *
     * @return void
     */
    public function handle(ExecutionService $executionService)
    {
        $execution = Execution::find(1);
//        $executionService->prepareRequirements($execution);

        $executionService->run($execution, true);
    }
}
