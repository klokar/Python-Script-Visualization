<?php

namespace App\Http\Livewire\Processor;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DataProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;

class ReplaceForm extends Component
{
    use WithFileUploads;

    public $processor_id;
    public $file;

    protected $rules = [
        'processor_id' => 'required|numeric',
        'file' => 'required|file',
    ];

    public function render()
    {
        return view('livewire.processor.replace-form');
    }

    public function replaceProcessor(Authenticatable $user)
    {
        $this->validate();

        $path = $this->file->store(DataProcessor::STORAGE_PATH);

        /** @var User $user */
        $processor = $user->programs()->findOrFail($this->processor_id);

        /** @var DataProcessor $processor */
        Storage::delete($processor->path);

        $processor->update([
            'path' => $path,
            'updated_at' => Carbon::now()
        ]);

        return redirect()
            ->to('processor');
    }
}
