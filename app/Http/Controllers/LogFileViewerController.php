<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Services\ServerFileReaderService;

class LogFileViewerController extends Controller
{
    protected $fileReaderService;

    public function __construct(ServerFileReaderService $fileReaderService)
    {
        $this->fileReaderService = $fileReaderService;
    }

    /**
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
        $page = $request->get('page', 1);
        $response = $this->fileReaderService->read($filePath);

        if($response['status'] !== 'error') {
            $response += $this->fileReaderService->paginate($response['message'], $page);
            unset($response['message']);
        }

        return response()->json($response);
    }
}
