<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Services\ServerFileReaderService;
use Exception;

class LogFileViewerController extends Controller
{
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

        if (!file_exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found!',
            ]);
        }

        $page = $request->get('page', 1);
        $pointer = $request->get('pointer');

        $fileReaderService = new ServerFileReaderService($filePath, 'r', $pointer);

        $count = 0;
        $data = [];
        foreach ($fileReaderService->lines() as $line) {

            $data[] = $line;
            $count++;

            if ($count === 10000 || $fileReaderService->isEndOfFile()) {
                $response = $fileReaderService->paginate($data, $page);
                $response += ['currentPointer' => $fileReaderService->currentPointer()];

                return response()->json($response);
            }
        }
    }
}
