<?php

namespace App\Http\Livewire\Execution;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Collection;
use App\Services\ExecutionService;
use Illuminate\Contracts\Auth\Authenticatable;

class CreateForm extends Component
{
    /** @var Collection */
    public $processors;
    /** @var Collection */
    public $datasets;

    public $data_processor_id;
    public $dataset_id;
    public $dataset_ev_id;
    public $test_set_size;
    public $comment;
    public $parameters;

    protected $rules = [
        'data_processor_id' => 'required|exists:data_processors,id',
        'dataset_id' => 'required|exists:datasets,id',
        'dataset_ev_id' => 'required|exists:datasets,id',
        'test_set_size' => 'required|numeric|min:1|max:100',
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

    public function createExecution(Authenticatable $user, ExecutionService $executionService)
    {
        $this->validate();

        /** @var User $user */
        $executionService->create(
            $user,
            $this->data_processor_id,
            $this->dataset_id,
            $this->dataset_ev_id,
            $this->test_set_size,
            $this->comment,
            $this->parameters,
        );

        return redirect()->to('execution');
    }
}
