<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class DependencyService
{
    const DEFAULT_FILE_PATH = 'dependencies/requirements.txt';

    /** @var string */
    protected $filePath;

    public function __construct($filePath = self::DEFAULT_FILE_PATH)
    {
        $this->filePath = $filePath;
    }

    public function parseDependencies(): Collection
    {
        $dependencyCollection = new Collection();

        try {
            $dependencyFile = Storage::disk('local')->get('dependencies/requirements.txt');
            $dependencyArray = explode(PHP_EOL, $dependencyFile);

            foreach ($dependencyArray as $item) {
                $itemParts = explode('==', $item);
                if (count($itemParts) == 2) {
                    $dependencyCollection->put($itemParts[0], $itemParts[1]);
                }
            }

            return $dependencyCollection;
        } catch (FileNotFoundException $fileNotFoundException) {
        }

        return $dependencyCollection;
    }
}
