<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Services\ServerFileReaderService;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class LogFileViewerController extends Controller
{
    protected $fileReaderService;

    public function __construct(ServerFileReaderService $fileReaderService)
    {
        $this->fileReaderService = $fileReaderService;
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request) : View
    {
        $fileLocation = $request->get('file_location', '/var/log/install.log');
        $data = $this->fileReaderService->read($fileLocation);
        $logs = array_slice($data, 0, 10);

        return view('log-viewer', compact('logs'));
    }

    /**
     * read file from server response if it exists and accessible
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getLogFileData(Request $request) : JsonResponse
    {
        $fileLocation = $request->get('file_location');
        $response = $this->fileReaderService->read($fileLocation);

        if($response['status'] !== 'error') {
            $response['logs'] = array_slice($response['message'], 0, 10);
            unset($response['message']);
        }

        return response()->json($response);
    }
}
