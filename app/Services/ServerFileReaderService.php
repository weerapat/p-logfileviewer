<?php

namespace App\Services;
use Exception;

class ServerFileReaderService
{
    private $maxReadFileSize = 30000000;

    /**
     * Reads file from server
     *
     * @param  string $filePath
     *
     * @return array
     */
    public function read(string $filePath) : array
    {

        if (\File::exists($filePath) && filesize($filePath) > $this->maxReadFileSize) {
            return [
                'status' => 'error',
                'message' => 'Log file cannot bigger than 30m',
            ];
        }

        if (!is_file($filePath)) {
            return [
                'status' => 'error',
                'message' => 'This file does not exist!',
            ];
        }

        try {
            $data = file($filePath);
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return [
            'status' => 'success',
            'message' => $data
        ];
    }
}
