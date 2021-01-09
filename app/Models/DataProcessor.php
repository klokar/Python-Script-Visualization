<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $path
 * @property string $filename
 * @property string $algorithm
 * @property string|null $processor_path
 * @property string|null $dataset_path
 * @property string|null $dataset_filename
 * @property string|null $results_path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DataProcessor extends Model
{
    public const STORAGE_PATH = 'processors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'algorithm', 'processor_path', 'dataset_path', 'dataset_filename', 'results_path'
    ];

    public function getFilenameAttribute(): string
    {
        return explode(self::STORAGE_PATH.'/', $this->path)[1];
    }

    /**
     * @param string $extension
     *
     * @return string|null
     */
    public static function getAlgorithmFromExtension(string $extension): ?string
    {
        switch ($extension) {
            case "py":
                return "pyhon";
            case "ipynb":
                return "jupyter notebook";
            default:
                return null;
        }
    }
}
