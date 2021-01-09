<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadProcessorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'file' => 'required|file',
            'processor_path' => 'nullable|string',
            'dataset_path' => 'nullable|string',
            'results_path' => 'nullable|string',
        ];
    }
}
