<?php

namespace App\Http\Livewire\Dataset;

use Livewire\Component;
use App\Models\Dataset;

class Delete extends Component
{
    public $confirming = false;

    public $dataset_id;

    protected $rules = [
        'dataset_id' => 'required|numeric',
    ];

    public function render()
    {
        return view('livewire.dataset.delete');
    }

    public function confirmDeletion()
    {
        $this->resetErrorBag();

//        $this->dispatchBrowserEvent('confirming-delete-user');

        $this->confirming = true;
    }

    public function deleteEntry() {

        Dataset::destroy([$this->dataset_id]);

        return redirect()
            ->to('dataset');
    }
}
