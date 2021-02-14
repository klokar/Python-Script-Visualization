<?php

namespace App\Http\Livewire\Dependency;

use Livewire\Component;
use App\Models\Dataset;
use App\Models\Dependency;
use App\Services\DependencyService;

class Delete extends Component
{
    public $confirming = false;

    public $dependency_id;

    protected $rules = [
        'dependency_id' => 'required|numeric',
    ];

    public function render()
    {
        return view('livewire.dependency.delete');
    }

    public function confirmDeletion()
    {
        $this->resetErrorBag();

        $this->confirming = true;
    }

    public function deleteEntry(DependencyService $dependencyService) {

        Dependency::destroy([$this->dependency_id]);

        $dependencyService->regenerateFile();

        return redirect()
            ->to('dependency');
    }
}
