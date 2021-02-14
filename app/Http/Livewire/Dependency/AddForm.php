<?php

namespace App\Http\Livewire\Dependency;

use Livewire\Component;
use App\Models\Dependency;
use App\Services\DependencyService;

class AddForm extends Component
{
    public $name;
    public $version;

    protected $rules = [
        'name' => 'required|string',
        'version' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.dependency.add-form');
    }

    public function addDependency(DependencyService $dependencyService)
    {
        $this->validate();

        Dependency::create([
            'name' => $this->name,
            'version' => $this->version,
        ]);

        $dependencyService->regenerateFile();

        return redirect()
            ->to('dependency');
    }
}
