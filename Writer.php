<?php

/**
 * This class is responsible for getting data from handler, creating and writing data to a CSV file.
 * The path to the file is defined by a constant PATH_FILE_WRITE.
 */

class Writer
{
    private Handler $handler;

    public function  __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function createCsv(): void
    {
        $file = fopen(PATH_FILE_WRITE, 'w');
        foreach ($this->handler->get() as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
    }
}