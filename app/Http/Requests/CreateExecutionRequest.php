<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExecutionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'data_processor_id' => 'required|exists:data_processors,id',
            'dataset_id' => 'required|exists:datasets,id',
            'comment' => 'nullable|string',
            'parameters' => 'nullable|string',
        ];
    }
}
