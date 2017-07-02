<?php

namespace App\Services;
use Exception;

class ServerFileReaderService
{
    /**
     * Read file from server
     *
     * @param  string $fileLocation
     *
     * @return array
     */
    public function read(string $fileLocation) : array
    {
        try {
            $data = file($fileLocation);
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
