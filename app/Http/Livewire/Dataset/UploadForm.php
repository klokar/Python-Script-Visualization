<?php

namespace App\Http\Livewire\Dataset;

use Livewire\Component;
use App\Models\Dataset;
use Livewire\WithFileUploads;

class UploadForm extends Component
{
    use WithFileUploads;

    public $name;
    public $file;

    protected $rules = [
        'name' => 'required|string',
        'file' => 'required|file',
    ];

    public function render()
    {
        return view('livewire.dataset.upload-form');
    }

    public function uploadDataset() {
        $this->validate();

        $path = $this->file->store('datasets');

        Dataset::create([
            'name' => $this->name,
            'original_name' => $this->file->getClientOriginalName(),
            'path' => $path,
            'size' => $this->file->getSize(),
        ]);

        return redirect()
            ->to('dataset');
    }
}
