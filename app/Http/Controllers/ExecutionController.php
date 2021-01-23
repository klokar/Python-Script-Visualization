<?php

namespace App\Http\Controllers;

use App\Models\Execution;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Authenticatable;

class ExecutionController extends Controller
{
    /**
     * @param Authenticatable $user
     *
     * @return View
     */
    public function index(Authenticatable $user)
    {
        return view('execution.list')
            ->with(
                'executions',
                $user->executions()->with('dataProcessor', 'dataset')
                    ->orderByDesc('id')
                    ->paginate(10)
            );
    }

    /**
     * @param Authenticatable $user
     * @param int             $id
     *
     * @return View
     */
    public function show(Authenticatable $user, $id)
    {
        /** @var Execution $execution */
        $execution = $user->executions()->findOrFail($id);
        $programDetails = $execution->programDetails();
        $evaluationDetails = $execution->evaluationDetails();
        $images = $execution->resultImages();

        return view('execution.report', [
            'execution' => $execution,
            'p_details' => $programDetails,
            'e_details' => $evaluationDetails,
            'images' => $images
        ]);
    }

    /**
     * @param Authenticatable $user
     *
     * @return View
     */
    public function create(Authenticatable $user)
    {
        return view('execution.create', ['processors' => $user->programs, 'datasets' => $user->datasets]);
    }

    /**
     * @param Authenticatable $user
     * @param                 $id
     *
     * @return View
     */
    public function output(Authenticatable $user, $id)
    {
        $execution = $user->executions()->findOrFail($id);

        return view('execution.output', ['output' => $execution->output(), 'execution' => $execution]);
    }
}
