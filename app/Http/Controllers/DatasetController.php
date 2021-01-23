<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Auth\Authenticatable;

class DatasetController extends Controller
{
    /**
     * @param Authenticatable $user
     *
     * @return View
     */
    public function index(Authenticatable $user)
    {
        return view('dataset.list')->with('datasets', $user->datasets()->paginate(10));
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('dataset.upload');
    }
}
