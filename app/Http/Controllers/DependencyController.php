<?php

namespace App\Http\Controllers;

use App\Models\Dependency;
use Illuminate\Contracts\View\View;

class DependencyController extends Controller
{
    public function index(): View
    {
        return view('dependency.list', [
            'dependencies' => Dependency::all()
        ]);
    }

    public function create(): View
    {
        return view('dependency.upload');
    }
}
