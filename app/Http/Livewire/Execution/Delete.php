<?php

namespace App\Http\Livewire\Execution;

use Livewire\Component;
use App\Models\Execution;

class Delete extends Component
{
    public $confirming = false;

    public $execution_id;

    protected $rules = [
        'execution_id' => 'required|numeric',
    ];

    public function render()
    {
        return view('livewire.execution.delete');
    }

    public function confirmDeletion()
    {
        $this->resetErrorBag();

        $this->confirming = true;
    }

    public function deleteEntry() {

        Execution::destroy([$this->execution_id]);

        return redirect()
            ->to('execution');
    }
}
