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
    public $e_path;
    public $e_path_result_figures;
    public $e_path_result_data;
    public $e_path_program_details;
    public $e_path_evaluation_details;
    public $level;
    public $comment;

    protected $rules = [
        'name' => 'required|string',
        'file' => 'required|file',
        'e_path' => 'required|string',
        'e_path_result_figures' => 'required|string',
        'e_path_result_data' => 'required|string',
        'e_path_program_details' => 'nullable|string',
        'e_path_evaluation_details' => 'nullable|string',
        'level' => 'required|integer',
        'comment' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.processor.upload-form');
    }

    public function uploadProcessor()
    {
        $this->validate();

        $path = $this->file->store(DataProcessor::STORAGE_PATH);

        DataProcessor::create([
            'name' => $this->name,
            'path' => $path,
            'e_path' => $this->e_path,
            'e_path_result_figures' => $this->e_path_result_figures,
            'e_path_result_data' => $this->e_path_result_data,
            'e_path_program_details' => $this->e_path_program_details,
            'e_path_evaluation_details' => $this->e_path_evaluation_details,
            'level' => $this->level,
            'comment' => $this->comment,
        ]);

        return redirect()
            ->to('processor');
    }
}
