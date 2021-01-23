<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Execution;
use App\Models\DataProcessor;
use Illuminate\Contracts\View\View;

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
     * @param int $id
     *
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
     * @param $id
     *
     * @return View
     */
    public function output($id)
    {
        $execution = Execution::findOrFail($id);

        return view('execution.output', ['output' => $execution->output(), 'execution' => $execution]);
    }
}
