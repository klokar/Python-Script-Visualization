<?php

namespace App\Services;

use App\Models\Dependency;
use Illuminate\Support\Facades\Storage;

class DependencyService
{
    /** @var PythonService */
    protected $pythonService;

    public function __construct(PythonService $pythonService)
    {
        $this->pythonService = $pythonService;
    }

    public function deleteOldFile(): void
    {
        Storage::delete($this->pythonService->requirementsBasePath());
    }

    public function regenerateFile(): void
    {
        $this->deleteOldFile();

        $content = "";
        foreach (Dependency::all() as $dependency) {
            $content .= sprintf("%s==%s\n", $dependency->name, $dependency->version);
        }

        Storage::put($this->pythonService->requirementsBasePath(), $content);
    }

    public function syncDependencies(): void
    {
        Dependency::truncate();

        $dependencyFile = Storage::get($this->pythonService->requirementsBasePath());
        $dependencyArray = explode(PHP_EOL, $dependencyFile);

        foreach ($dependencyArray as $item) {
            $itemParts = explode('==', $item);
            if (count($itemParts) == 2) {
                Dependency::insert([
                    'name' => $itemParts[0],
                    'version' => $itemParts[1],
                ]);
            }
        }
    }
}
