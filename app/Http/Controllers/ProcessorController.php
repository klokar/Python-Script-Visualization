<?php

namespace App\Http\Controllers;

use App\Models\DataProcessor;
use Illuminate\Contracts\View\View;
use App\Services\DependencyService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UploadProcessorRequest;

class ProcessorController extends Controller
{
    /**
     * @param DependencyService $dependencyService
     *
     * @return View
     */
    public function index(DependencyService $dependencyService)
    {
        $dependencies = $dependencyService->parseDependencies();

        return view('processor.list', [
            'processors' => DataProcessor::paginate(10),
            'dependencies' => $dependencies
        ]);
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('processor.upload');
    }
}
