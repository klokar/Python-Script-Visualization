<?php

namespace App\Http\Livewire\Dataset;

use App\Models\User;
use Livewire\Component;
use App\Models\Dataset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;

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

        $this->confirming = true;
    }

    public function deleteEntry(Authenticatable $user) {

        /** @var User $user */
        $dataset = $user->datasets()->findOrFail($this->dataset_id);

        /** @var Dataset $dataset */
        Storage::delete($dataset->path);

        $dataset->delete();

        return redirect()
            ->to('dataset');
    }
}
