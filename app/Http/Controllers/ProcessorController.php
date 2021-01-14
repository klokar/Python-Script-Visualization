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
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        // TODO
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('processor.upload');
    }

    /**
     * @param  int  $id
     *
     * @return int
     */
    public function destroy($id)
    {
        return DataProcessor::destroy([$id]);
    }

    /**
     * @param UploadProcessorRequest $request
     *
     * @return RedirectResponse
     */
    public function store(UploadProcessorRequest $request)
    {
        $file = $request->file('file');
        $path = $file->store(DataProcessor::STORAGE_PATH);
        $fileType = DataProcessor::getAlgorithmFromExtension($file->extension());

        DataProcessor::create([
            'name' => $request->get('name'),
            'path' => $path,
            'algorithm' => $fileType,
            'processor_path' => $request->get('processor_path'),
            'dataset_path' => $request->get('dataset_path'),
            'results_path' => $request->get('results_path'),
        ]);

        return redirect()
            ->to('processor');
    }
}
