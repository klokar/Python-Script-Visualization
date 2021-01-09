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
        logger()->debug('d', ['d' => Dataset::all()]);
        return view('dataset.list')->with('datasets', Dataset::all());
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
        return view('dataset.upload');
    }

    /**
     * @param  int  $id
     *
     * @return int
     */
    public function destroy($id)
    {
        return Dataset::destroy([$id]);
    }

    /**
     * @param UploadDatasetRequest $request
     *
     * @return RedirectResponse
     */
    public function store(UploadDatasetRequest $request)
    {
        $file = $request->file('file');
        $path = $file->store('datasets');

        Dataset::create([
            'name' => $request->get('name'),
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
        ]);

        return redirect()
            ->to('dataset');
    }
}
