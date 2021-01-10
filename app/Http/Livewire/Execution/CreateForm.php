<?php

namespace App\Http\Livewire\Execution;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Services\ExecutionService;

class CreateForm extends Component
{
    /** @var Collection */
    public $processors;
    /** @var Collection */
    public $datasets;

    public $data_processor_id;
    public $dataset_id;
    public $comment;
    public $parameters;

    protected $rules = [
        'data_processor_id' => 'required|exists:data_processors,id',
        'dataset_id' => 'required|exists:datasets,id',
        'comment' => 'nullable|string',
        'parameters' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.execution.create-form');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createExecution(ExecutionService $executionService) {
        $this->validate();

        $executionService->createAndRun(
            $this->data_processor_id,
            $this->dataset_id,
            $this->comment,
            $this->parameters,
        );

        return redirect()->to('execution');
    }
}
