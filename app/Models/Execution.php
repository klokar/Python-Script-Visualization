<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int           $id
 * @property string        $hash
 * @property int           $data_processor_id
 * @property int           $dataset_id
 * @property int           $test_set_size
 * @property string|null   $comment
 * @property string|null   $parameters
 * @property int           $status
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 * @property DataProcessor $dataProcessor
 * @property Dataset       $dataset
 * @property Dataset       $datasetEv
 */
class Execution extends Model
{
    public const STATUS_CREATED = 0;
    public const STATUS_QUEUED = 1;
    public const STATUS_STARTED = 2;
    public const STATUS_COMPLETE = 3;
    public const STATUS_ERROR = 4;

    public const PROCESSOR_FILENAME = 'program.py';
    public const DATASET_FILENAME = 'data.csv';
    public const DATASET_EV_FILENAME = 'data_ev.csv';
    public const PROCESSING_DETAILS_FILENAME = 'data.json';
    public const EVALUATION_DETAILS_FILENAME = 'data_ev.json';
    public const OUTPUT_FILENAME = 'output.log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash', 'data_processor_id', 'dataset_id', 'test_set_size', 'comment', 'parameters', 'status', 'created_at', 'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dataProcessor(): BelongsTo
    {
        return $this->belongsTo(DataProcessor::class);
    }

    public function dataset(): BelongsTo
    {
        return $this->belongsTo(Dataset::class, 'dataset_id');
    }

    public function setStatus(int $status): void
    {
        $this->update(['status' => $status]);
    }

    public function output(): array
    {
        $output = [];

        if (Storage::exists($this->outputPath())) {
            $lines = explode("\n", Storage::get($this->outputPath()));
            $nonEmptyLines = array_filter($lines, function ($line) {
                return !empty($line);
            });

            return array_map(function ($line) {
                return Output::decode($line);
            }, $nonEmptyLines);
        }

        return $output;
    }

    public function programDetails(): array
    {
        $data = [];

        if (Storage::exists($this->detailsProcessingPath())) {
            $data = json_decode(Storage::get($this->detailsProcessingPath()), true);
        }

        return $data;
    }

    public function evaluationDetails(): array
    {
        $data = [];

        if (Storage::exists($this->detailsEvaluationPath())) {
            $data = json_decode(Storage::get($this->detailsEvaluationPath()), true);
        }

        return $data;
    }

    public function resultImages(): array
    {
        if (Storage::exists($this->resultFiguresPath())) {
            $urls = Storage::allFiles($this->resultFiguresPath());
            asort($urls);

            return $this->hashForURLs($urls);
        }

        return [];
    }

    public function hashForURLs(array $URLs)
    {
        $hashData = [];
        foreach ($URLs as $url) {
            $hashData[md5($url)] = $url;
        }

        return $hashData;
    }

    public function storagePath(): string
    {
        return storage_path(sprintf('app/executions/%s', $this->hash));
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

    public function outputPath(): string // executions/hash/iris/output.log
    {
        return sprintf('%s/%s', $this->executionPath(), self::OUTPUT_FILENAME);
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

    public function resultFiguresShortPath(): string // ris/IrisFigures
    {
        return sprintf('%s/%s', $this->executionShortPath(), $this->dataProcessor->e_path_result_figures);
    }

    public function resultFiguresPath(): string // executions/hash/iris/IrisFigures
    {
        return sprintf('%s/%s', $this->executionPath(), $this->dataProcessor->e_path_result_figures);
    }

    public function resultDataShortPath(): string // iris/IrisResults
    {
        return sprintf('%s/%s', $this->executionShortPath(), $this->dataProcessor->e_path_result_data);
    }

    public function resultDataPath(): string // executions/hash/iris/IrisResults
    {
        return sprintf('%s/%s', $this->executionPath(), $this->dataProcessor->e_path_result_data);
    }

    public function detailsProcessingPath(): string // executions/hash/iris/data.json
    {
        return sprintf('%s/%s', $this->executionPath(), self::PROCESSING_DETAILS_FILENAME);
    }

    public function detailsEvaluationPath(): string // executions/hash/iris/data_ev.json
    {
        return sprintf('%s/%s', $this->executionPath(), self::EVALUATION_DETAILS_FILENAME);
    }
}
