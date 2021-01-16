<?php

namespace App\Http\Livewire\Processor;

use Livewire\Component;
use App\Models\DataProcessor;

class Delete extends Component
{
    public $confirming = false;

    public $processor_id;

    protected $rules = [
        'processor_id' => 'required|numeric',
    ];

    public function render()
    {
        return view('livewire.processor.delete');
    }

    public function confirmDeletion()
    {
        $this->resetErrorBag();

        $this->confirming = true;
    }

    public function deleteEntry() {

        DataProcessor::destroy([$this->processor_id]);

        return redirect()
            ->to('processor');
    }
}
