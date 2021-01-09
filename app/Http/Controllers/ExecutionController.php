<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Dataset;
use App\Models\Execution;
use App\Models\DataProcessor;
use App\Services\ExecutionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CreateExecutionRequest;

class ExecutionController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Execution', [
            'executions' => Execution::with('dataProcessor', 'dataset')->orderByDesc('id')->get()
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
        return view('execution.create', ['processors' => DataProcessor::all(), 'datasets' => Dataset::all()]);
    }

    /**
     * @param  int  $id
     *
     * @return int
     */
    public function destroy($id)
    {
        return Execution::destroy([$id]);
    }

    /**
     * @param CreateExecutionRequest $request
     * @param ExecutionService       $executionService
     *
     * @return RedirectResponse
     */
    public function store(CreateExecutionRequest $request, ExecutionService $executionService)
    {
        $executionService->createAndRun(
            $request->get('data_processor_id'),
            $request->get('dataset_id'),
            $request->get('comment'),
            $request->get('parameters')
        );

//        return redirect()
//            ->to('execution');
    }
}
