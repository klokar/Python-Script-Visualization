<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string      $name
 * @property string      $path
 * @property string      $filename
 * @property string      $e_path
 * @property string      $e_path_result_figures
 * @property string      $e_path_result_data
 * @property string|null $e_path_program_details
 * @property string|null $e_path_evaluation_details
 * @property integer     $level
 * @property string|null $comment
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
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
        'name', 'path', 'e_path', 'e_path_result_figures', 'e_path_result_data', 'e_path_program_details',
        'e_path_evaluation_details', 'level', 'comment', 'updated_at'
    ];

    /**
     * @param string $extension
     *
     * @return string|null
     */
    public static function getAlgorithmFromExtension(string $extension): ?string
    {
        switch ($extension) {
            case "py":
                return "python script";
            case "ipynb":
                return "jupyter notebook";
            default:
                return null;
        }
    }

    public function getFilenameAttribute(): string
    {
        return explode(self::STORAGE_PATH . '/', $this->path)[1];
    }
}
