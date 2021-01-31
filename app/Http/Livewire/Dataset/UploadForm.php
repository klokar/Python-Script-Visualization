<?php

namespace App\Http\Livewire\Dataset;

use App\Models\User;
use Livewire\Component;
use App\Models\Dataset;
use Livewire\WithFileUploads;
use Illuminate\Contracts\Auth\Authenticatable;

class UploadForm extends Component
{
    use WithFileUploads;

    public $name;
    public $file;
    public $comment;

    protected $rules = [
        'name' => 'required|string',
        'file' => 'required|file',
        'comment' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.dataset.upload-form');
    }

    public function uploadDataset(Authenticatable $user)
    {
        $this->validate();

        $path = $this->file->store('datasets');

        /** @var User $user */
        $user->datasets()->save(
            new Dataset([
                'name' => $this->name,
                'original_name' => $this->file->getClientOriginalName(),
                'path' => $path,
                'size' => $this->file->getSize(),
                'comment' => $this->comment,
            ])
        );

        return redirect()
            ->to('dataset');
    }
}
