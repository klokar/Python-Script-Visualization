<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateReportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'action' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public function isDownloadReport(): string
    {
        return $this->has('action') && $this->get('action') === 'download';
    }

    public function getTitle(): string
    {
        return $this->get('title');
    }

    public function getDescription(): string
    {
        return $this->get('description');
    }

    public function getImageHashes(): array
    {
        $hashes = [];
        foreach ($this->all() as $key => $value) {
            if (str_contains($key, 'check') && $value === 'on') {
                $hash = explode('-', $key)[0];
                $hashes[$hash] = $this->get(sprintf('%s-title', $hash));
            }
        }

        return $hashes;
    }
}
