<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string        $hash
 * @property int           $data_processor_id
 * @property int           $dataset_id
 * @property int           $dataset_ev_id
 * @property int           $test_set_size
 * @property string|null   $comment
 * @property string|null   $parameters
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 * @property DataProcessor $dataProcessor
 * @property Dataset       $dataset
 * @property Dataset       $datasetEv
 */
class Execution extends Model
{
    public const PROCESSOR_FILENAME = 'program.py';
    public const DATASET_FILENAME = 'data.csv';
    public const DATASET_EV_FILENAME = 'data_ev.csv';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash', 'data_processor_id', 'dataset_id', 'dataset_ev_id', 'test_set_size', 'comment', 'parameters', 'created_at', 'updated_at',
    ];

    public function dataProcessor(): BelongsTo
    {
        return $this->belongsTo(DataProcessor::class);
    }

    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class, 'dataset_id');
    }

    public function datasetEv(): BelongsTo
    {
        return $this->belongsTo(Dataset::class, 'dataset_ev_id');
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

    public function basePath(): string // executions/hash
    {
        return sprintf('executions/%s', $this->hash);
    }

    public function executionPath(): string // executions/hash/iris
    {
        return sprintf('%s/%s', $this->basePath(), $this->dataProcessor->e_path);
    }

    public function executionShortPath(): string // iris
    {
        return $this->dataProcessor->e_path;
    }

    public function processorPath(): string // executions/hash/iris/program.py
    {
        return sprintf('%s/%s', $this->executionPath(), self::PROCESSOR_FILENAME);
    }

    public function processorShortPath(): string // iris/program.py
    {
        return sprintf('%s/%s', $this->executionShortPath(), self::PROCESSOR_FILENAME);
    }

    public function datasetPath(): string // executions/hash/iris/data.csv
    {
        return sprintf('%s/%s', $this->executionPath(), self::DATASET_FILENAME);
    }

    public function datasetShortPath(): string // iris/data.csv
    {
        return sprintf('%s/%s', $this->executionShortPath(), self::DATASET_FILENAME);
    }

    public function datasetEvPath(): string // executions/hash/iris/data_ev.csv
    {
        return sprintf('%s/%s', $this->executionPath(), self::DATASET_EV_FILENAME);
    }

    public function datasetEvShortPath(): string // iris/data_ev.csv
    {
        return sprintf('%s/%s', $this->executionShortPath(), self::DATASET_EV_FILENAME);
    }
}
