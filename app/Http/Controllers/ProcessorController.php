<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Services\DependencyService;
use Illuminate\Contracts\Auth\Authenticatable;

class ProcessorController extends Controller
{
    /**
     * @param DependencyService $dependencyService
     *
     * @param Authenticatable   $user
     *
     * @return View
     */
    public function index(DependencyService $dependencyService, Authenticatable $user)
    {
        return view('processor.list', [
            'processors' => $user->programs()->paginate(10),
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
