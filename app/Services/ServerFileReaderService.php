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

    /**
     * Paginate the given array
     *
     * @param  array  $contents
     * @param  int  $page
     * @param  int  $perPage
     *
     * @return array
     */
    public function paginate(array $contents, int $page, int $perPage = 10) : array
    {
        $totalPages = ceil(count($contents) / $perPage);
        $startOffset = ($page - 1) * $perPage;

        return [
            'page' => $page,
            'logs' => array_slice($contents, $startOffset, $perPage),
            'totalPages' => $totalPages,
        ];
    }
}
