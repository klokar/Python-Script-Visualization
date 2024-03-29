<?php

namespace App\Http\Livewire\Processor;

use App\Models\User;
use Livewire\Component;
use App\Models\DataProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;

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

    public function deleteEntry(Authenticatable $user) {

        /** @var User $user */
        $processor = $user->programs()->findOrFail($this->processor_id);

        /** @var DataProcessor $processor */
        Storage::delete($processor->path);

        $processor->delete();

        return redirect()
            ->to('processor');
    }
}
