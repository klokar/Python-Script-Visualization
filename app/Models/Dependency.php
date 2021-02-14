<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string      $name
 * @property string      $version
 */
class Dependency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'version',
    ];
}
