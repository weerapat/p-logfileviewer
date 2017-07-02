<?php

namespace App\Services;
use Exception;

class ServerFileReaderService
{
    /**
     * Reads file from server
     *
     * @param  string $filePath
     *
     * @return array
     */
    public function read(string $filePath) : array
    {
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
