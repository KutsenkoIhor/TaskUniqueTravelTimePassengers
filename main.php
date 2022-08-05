<?php

include_once('Reader.php');
include_once('Handler.php');
include_once('Writer.php');

const PATH_FILE_READ = "trips.csv";
const PATH_FILE_WRITE = "report.csv";
const MAX_STRING_LENGTH = 100;

$handler = new Handler();
$reader = new Reader($handler);
$reader->read();
$handler->run();
$writer = new Writer($handler);
$writer->createCsv();
