<?php

namespace App\Services;

class FileReaderService
{
    protected $file;
    protected $buffer;
    protected $isEndOfFile;

    /**
     * @param string $filename
     * @param string $mode
     * @param int $pointer
     *
     * @return array
     */
    public function read(string $filename, string $mode, int $pointer): array
    {
        $this->file = fopen($filename, $mode);
        fseek($this->file, $pointer);
        $this->buffer = false;
        $this->isEndOfFile = false;

        $count = 0;
        $data = [];
        foreach ($this->lines() as $line) {
            $data[] = $line;
            $count++;

            if ($count === 10000 || $this->isEndOfFile()) {
                return $data;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function chunks() : \Generator
    {
        while (true) {
            $chunk = fread($this->file, 8192);
            if (strlen($chunk)) yield $chunk;
            elseif (feof($this->file)) {
                $this->isEndOfFile = true;
                break;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function lines() : \Generator
    {
        foreach ($this->chunks() as $chunk) {
            $lines = explode("\n", $this->buffer . $chunk);

            $this->buffer = array_pop($lines);

            foreach ($lines as $line) yield $line;
        }
        if ($this->buffer !== false) {
            yield $this->buffer;
        }
    }

    /**
     * @return bool
     */
    public function isEndOfFile() : bool
    {
        return $this->isEndOfFile;
    }

    /**
     * Checking current position of pointer
     *
     * @return int
     */
    public function currentPointer() : int
    {
        if ($this->isEndOfFile) {
            return 0;
        }

        return ftell($this->file);
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

        if ($totalPages >= 1000) {
            $totalPages = (floor($page / 1000) + 1) * 1000;
        }

        $startOffset = (($page % 1000) - 1) * $perPage;

        return [
            'page' => $page,
            'logs' => array_slice($contents, $startOffset, $perPage),
            'totalPages' => $totalPages,
        ];
    }
}
