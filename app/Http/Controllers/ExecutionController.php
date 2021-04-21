<?php

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use App\Models\Execution;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\GenerateReportRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

        return view('execution.report', [
            'execution' => $execution,
            'program' => $execution->dataProcessor,
            'dataset' => $execution->dataset,
            'p_details' => $execution->programDetails(),
            'e_details' => $execution->evaluationDetails(),
            'images' => $execution->resultImages()
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
        /** @var Execution $execution */
        $execution = $user->executions()->findOrFail($id);

        return view('execution.output', ['output' => $execution->output(), 'execution' => $execution]);
    }

    public function downloadFiles(Authenticatable $user, $id)
    {
        /** @var Execution $execution */
        $execution = $user->executions()->findOrFail($id);

        $zip = new ZipArchive;
        $dir = 'archive';

        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $fileName = sprintf('%s/%s.zip', $dir, $execution->hash);

        if (true === ($zip->open(public_path($fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE))) {
            foreach (Storage::allFiles($execution->basePath()) as $file) {
                $zip->addFile(public_path($file), basename($file));
            }
        }

        $zip->close();

        return response()->download(public_path($fileName));
    }

    /**
     * @param GenerateReportRequest $request
     * @param Authenticatable       $user
     * @param                       $id
     *
     * @return Response|View|BinaryFileResponse
     */
    public function report(GenerateReportRequest $request, Authenticatable $user, $id)
    {
        /** @var Execution $execution */
        $execution = $user->executions()->findOrFail($id);
        $hashUrls = $execution->resultImages();

        $imageTitles = [];
        foreach ($request->getImageHashes() as $hash => $title) {
            $imageTitles[$hashUrls[$hash]] = $title;
        }

        if($request->isDownloadReport()) {
            $pdf = app('snappy.pdf.wrapper')->loadView('execution.report-pdf', [
                'title' => $request->getTitle(),
                'description' => $request->getDescription(),
                'images' => $imageTitles,
                'execution' => $execution,
                'program' => $execution->dataProcessor,
                'dataset' => $execution->dataset,
                'p_details' => $execution->programDetails(),
                'e_details' => $execution->evaluationDetails(),
            ]);

            return $pdf->download(sprintf('porocilo_%s.pdf', Carbon::now()->toDateTimeString()));
        } else {
            return view('execution.report-view', [
                'title' => $request->getTitle(),
                'description' => $request->getDescription(),
                'images' => $imageTitles,
                'execution' => $execution,
                'program' => $execution->dataProcessor,
                'dataset' => $execution->dataset,
                'p_details' => $execution->programDetails(),
                'e_details' => $execution->evaluationDetails(),
            ]);
        }
    }
}
