<?php

namespace App\Http\Livewire\Execution;

use Livewire\Component;
use App\Models\Execution;
use App\Services\ExecutionService;
use Illuminate\Support\Facades\Artisan;

class Run extends Component
{
    public $execution_id;

    protected $rules = [
        'execution_id' => 'required|numeric',
    ];

    public function render()
    {
        return view('livewire.execution.run');
    }

    public function run(ExecutionService $executionService)
    {
//        $execution = Execution::findOrFail($this->execution_id);
//        $executionService->run($execution, true);
        Artisan::queue('execution:run', ['id' => $this->execution_id]);

        return redirect()
            ->to("execution/$this->execution_id/output");
    }
}
