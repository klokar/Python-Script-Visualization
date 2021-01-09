<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string        $hash
 * @property int           $data_processor_id
 * @property int           $dataset_id
 * @property string|null   $comment
 * @property string|null   $parameters
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 * @property DataProcessor $dataProcessor
 * @property Dataset       $dataset
 */
class Execution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash', 'data_processor_id', 'dataset_id', 'comment', 'parameters', 'created_at', 'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function dataProcessor(): BelongsTo
    {
        return $this->belongsTo(DataProcessor::class);
    }

    /**
     * @return BelongsTo
     */
    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class);
    }

    public function storagePath(): string
    {
        return storage_path(sprintf('app/executions/%s', $this->hash));
    }

    public function venvPath(): string
    {
        return sprintf('%s/env', $this->storagePath());
    }

    public function pipPath(): string
    {
        return sprintf('%s/bin/pip3', $this->venvPath());
        // In case of not using VENV -> return 'pip3';
    }

    public function pythonPath(): string
    {
        return sprintf('%s/bin/python3', $this->venvPath());
        // In case of not using VENV -> return 'python3';
    }

    public function processorPath(): string
    {
        $processorFilename = $this->dataProcessor->filename;

        // Append custom execution path if exists
        $processorExecutionPath = $this->dataProcessor->processor_path;
        if (!empty($processorExecutionPath)) {
            $processorFilename = sprintf('%s/%s', $processorExecutionPath, $processorFilename);
        }

        return sprintf('%s/%s', $this->shortPath(), $processorFilename);
    }

    public function shortPath(): string
    {
        return sprintf('executions/%s', $this->hash);
    }

    public function datasetPath(): string
    {
        // Set path to original name if execution path not present
        $datasetExecutionPath = $this->dataProcessor->dataset_path;
        if (empty($datasetExecutionPath)) {
            $datasetExecutionPath = $this->dataset->original_name;
        }

        return sprintf('%s/%s', $this->shortPath(), $datasetExecutionPath);
    }
}
