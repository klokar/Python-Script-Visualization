<?php

namespace App\Services;

use Exception;
use App\Models\Execution;
use App\Traits\ProcessRunner;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use App\Contracts\ProgramExecutorServiceInterface;

class PythonService implements ProgramExecutorServiceInterface
{
    use ProcessRunner;

    const PYTHON_EXECUTABLE = 'python3';
    const DEPENDENCIES_CACHE_FOLDER = 'cache';
    const DEPENDENCIES_REQUIREMENTS_FILE = 'requirements.txt';

    protected $out;

    public function __construct(OutputService $outputService)
    {
        $this->out = $outputService;
    }

    public function getExecutable(): string
    {
        return $this->pythonPath();
    }

    protected function pythonPath(): string // app/python/venv/bin/python3
    {
        return sprintf('%s/bin/%s', $this->venvPath(), self::PYTHON_EXECUTABLE);
        // In case of not using VENV -> return 'python3';
    }

    public function venvPath(): string // app/python/venv
    {
        return sprintf('%s/venv', $this->storagePath());
    }

    protected function storagePath(): string // app/python
    {
        return storage_path('app/python');
    }

    public function prepare(Execution $execution, bool $displayTrace = false): void
    {
        $this->createVirtualEnvironment($execution, $displayTrace);
        $this->prepareRequirements($execution, $displayTrace);
    }

    protected function createVirtualEnvironment(Execution $execution, bool $displayTrace = false): void
    {
        if (!Storage::exists($this->venvBasePath())) {
            $process = new Process([
                self::PYTHON_EXECUTABLE,
                '-m',
                'venv',
                $this->venvPath(),
            ]);
            $this->runProcess($execution, $process, $this->out, $displayTrace);
            $this->out->success($execution, 'Created python virtual environment: ' . $this->venvPath());

            // Update pip as some requirements need latest version
            $process = new Process([
                $this->pipPath(),
                'install',
                '--upgrade',
                'pip',
                'setuptools',
            ]);
            $this->runProcess($execution, $process, $this->out, $displayTrace);
            $this->out->success($execution, 'Upgraded pip and setuptools');
        } else {
            $this->out->success($execution, 'Python virtual environment already exists: ' . $this->venvPath());
        }
    }

    public function venvBasePath(): string // app/python/venv
    {
        return sprintf('%s/venv', $this->basePath());
    }

    public function basePath(): string // python
    {
        return 'python';
    }

    protected function pipPath(): string
    {
        return sprintf('%s/bin/pip3', $this->venvPath());
        // In case of not using VENV -> return 'pip3';
    }

    protected function cachePath(): string // app/python/dependencies/cache
    {
        return sprintf('%s/%s', $this->dependenciesPath(), self::DEPENDENCIES_CACHE_FOLDER);
    }

    protected function requirementsPath(): string // app/python/dependencies/requirements.txt
    {
        return sprintf('%s/%s', $this->dependenciesPath(), self::DEPENDENCIES_REQUIREMENTS_FILE);
    }

    public function requirementsBasePath(): string // python/dependencies/requirements.txt
    {
        return sprintf('%s/%s', $this->dependenciesBasePath(), self::DEPENDENCIES_REQUIREMENTS_FILE);
    }

    protected function prepareRequirements(Execution $execution, bool $displayTrace = false, int $timeout = 15)
    {
        // Storage dir should be owned by root:root - chown -R root:root storage/
        // If want to copy dependencies to current dir add '-t', './',
        $process = new Process([
            $this->pipPath(),
            'install',
            '--cache-dir',
            $this->cachePath(),
            '-r',
            $this->requirementsPath(),
            '--disable-pip-version-check',
        ]);

        $process->setWorkingDirectory($this->storagePath());
        $process->setTimeout(60 * $timeout);
        $this->runProcess($execution, $process, $this->out, $displayTrace);

        $this->out->success($execution, 'Requirements handled: ' . $this->requirementsPath());
    }

    public function dependenciesPath(): string // app/python/dependencies
    {
        return sprintf('%s/dependencies', $this->storagePath());
    }

    public function dependenciesBasePath(): string // python/dependencies
    {
        return sprintf('%s/dependencies', $this->basePath());
    }

    public function clear(Execution $execution, bool $displayTrace = false): void
    {
        $this->out->success($execution, 'Nothing to clear in python VENV');
    }

    protected function disconnectVirtualEnvironment(Execution $execution, bool $displayTrace = false): void
    {
        try {
            $process = new Process([
                'rm',
                '-rf',
                $this->venvPath(),
            ]);
            $this->runProcess($execution, $process, $this->out, $displayTrace);
            $this->out->success($execution, 'Disconnected python virtual environment');
        } catch (Exception $e) {
            $this->out->error($execution, 'Disconnected python virtual environment');
        }
    }
}
