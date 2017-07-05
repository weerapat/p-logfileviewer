<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Services\FileReaderService;

class LogFileViewerController extends Controller
{
    /* @var FileReaderService */
    protected $fileReaderService;

    public function __construct(FileReaderService $fileReaderService)
    {
        $this->fileReaderService = $fileReaderService;
    }

    /**
     * Get index view
     *
     * @return View
     */
    public function index() : View
    {
        return view('log-viewer');
    }

    /**
     * Reads entire file from server into an array
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getLogFileData(Request $request) : JsonResponse
    {
        $filePath = $request->get('file_path');
        $page     = $request->get('page', 1);
        $pointer  = $request->get('pointer');

        if (!file_exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found!',
            ]);
        }

        $data = $this->fileReaderService->read($filePath, 'r', $pointer);

        $response = $this->fileReaderService->paginate($data, $page);
        $response += ['currentPointer' => $this->fileReaderService->currentPointer()];

        return response()->json($response);
    }
}
