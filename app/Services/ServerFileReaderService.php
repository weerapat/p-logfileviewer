<?php

namespace App\Services;

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
        $file = $fileLocation;
        $data = file($file);

        return $data;
    }
}
