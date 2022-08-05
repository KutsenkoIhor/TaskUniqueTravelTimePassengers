<?php

/**
 * This class is responsible for reading data from the file and passing it to the handler.
 * Class checks for the existence of a file and the ability to read it.
 * The path to the file is defined by a constant PATH_FILE_READ.
 */

class Reader
{
    private Handler $handler;

    public function  __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function read(): void
    {
        if (file_exists(PATH_FILE_READ)) {
            if (($file = fopen(PATH_FILE_READ, 'r')) !== false) {
                $flag = true;
                /**
                 * $flag is used to skip 1 line of the file.
                 * We specify the length of the string to make the code faster.
                 */
                while (($data = fgetcsv($file, MAX_STRING_LENGTH, ",")) !== false) {
                    if ($flag) {
                        $flag = false;
                        continue;
                    }
                    $idDriver = $data[1];
                    $unixTimePickup = strtotime($data[2]);
                    $unixTimeDropOff = strtotime($data[3]);

                    $this->handler->set($idDriver, $unixTimePickup, $unixTimeDropOff);
                }
                fclose($file);
            } else {
                print_r("permission error");
            }
        } else {
            print_r("File does not exist");
        }
    }
}