<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class DependencyService
{
    /** @var string */
    protected $filePath;

    public function __construct(PythonService $pythonService)
    {
        $this->filePath = $pythonService->requirementsBasePath();
    }

    public function parseDependencies(): Collection
    {
        $dependencyCollection = new Collection();

        try {
            $dependencyFile = Storage::get($this->filePath);
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
