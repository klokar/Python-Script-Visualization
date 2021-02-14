<?php

namespace App\Http\Livewire\Dependency;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\PythonService;
use App\Services\DependencyService;

class UploadForm extends Component
{
    use WithFileUploads;

    public $file;

    protected $rules = [
        'file' => 'required|file',
    ];

    public function render()
    {
        return view('livewire.dependency.upload-form');
    }

    public function uploadDependencies(PythonService $pythonService, DependencyService $dependencyService)
    {
        $this->validate();

        $dependencyService->deleteOldFile();
        $this->file->storeAs(
            $pythonService->dependenciesBasePath(),
            PythonService::DEPENDENCIES_REQUIREMENTS_FILE
        );

        $dependencyService->syncDependencies();

        return redirect()
            ->to('dependency');
    }
}
