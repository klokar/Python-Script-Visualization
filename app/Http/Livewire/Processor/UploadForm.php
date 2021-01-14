<?php

namespace App\Http\Livewire\Processor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DataProcessor;

class UploadForm extends Component
{
    use WithFileUploads;

    public $name;
    public $file;
    public $processor_path;
    public $dataset_path;
    public $results_path;

    protected $rules = [
        'name' => 'required|string',
        'file' => 'required|file',
        'processor_path' => 'nullable|string',
        'dataset_path' => 'nullable|string',
        'results_path' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.processor.upload-form');
    }

    public function uploadProcessor() {
        $this->validate();

        $path = $this->file->store(DataProcessor::STORAGE_PATH);
        $fileType = DataProcessor::getAlgorithmFromExtension($this->file->extension());

        DataProcessor::create([
            'name' => $this->name,
            'path' => $path,
            'algorithm' => $fileType,
            'processor_path' => $this->processor_path,
            'dataset_path' => $this->dataset_path,
            'results_path' => $this->results_path,
        ]);

        return redirect()
            ->to('processor');
    }
}
