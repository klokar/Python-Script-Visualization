<?php

namespace App\Http\Livewire\Execution;

use Livewire\Component;
use App\Models\Execution;
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

    public function run()
    {
        /** @var Execution $execution */
        $execution = Execution::find($this->execution_id);
        $execution->setStatus(Execution::STATUS_QUEUED);

        Artisan::queue('execution:run', ['id' => $execution->id]);

        return redirect()
            ->to("execution/$this->execution_id/output");
    }
}
