<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\ServerFileReaderService;

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
}
