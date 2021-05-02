<?php

namespace App\Http\Livewire\Execution;

use App\Models\User;
use Livewire\Component;
use App\Models\Execution;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;

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

    public function deleteEntry(Authenticatable $user)
    {
        /** @var User $user */
        $execution = $user->executions()->findOrFail($this->execution_id);

        /** @var Execution $execution */
        Storage::deleteDirectory($execution->basePath());

        $execution->delete();

        return redirect()
            ->to('execution');
    }
}
