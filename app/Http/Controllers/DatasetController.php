<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UploadDatasetRequest;

class DatasetController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        return view('dataset.list')->with('datasets', Dataset::paginate(10));
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('dataset.upload');
    }
}
