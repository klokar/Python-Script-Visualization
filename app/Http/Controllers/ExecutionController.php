<?php

namespace App\Http\Controllers;

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
     * @return View
     */
    public function index()
    {
        return view('execution.list')
            ->with(
                'executions',
                Execution::with('dataProcessor', 'dataset')
                    ->orderByDesc('id')
                    ->paginate(10)
            );
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
}
