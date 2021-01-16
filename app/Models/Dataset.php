<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string      $name
 * @property string      $original_name
 * @property string      $path
 * @property int         $size
 * @property string      $formatted_size
 * @property string|null $comment
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 */
class Dataset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'original_name', 'path', 'size', 'comment',
    ];

    public function getFormattedSizeAttribute(): string
    {
        $divider = 1000; // Can be 1024
        $precision = 2;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($this->size, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log($divider));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow($divider, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
