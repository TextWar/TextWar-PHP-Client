<?php
require_once "autoload.php";
error_reporting(E_ALL);
ini_set('display_errors', false);
$log = new \yxmingy\Logger("[TextWar]");
set_error_handler(function ($error_no, $error_str, $error_file, $error_line) use($log){
    $log->error("In file ".$error_file." ".$error_str." at line ".$error_line);
    exit();
}, E_ALL | E_STRICT);
try {
    require_once "test.php";
} catch (\Exception $e) {
    $log->error(
      "In file ".$e->getFile()
      ." ".$e->getMessage()
      ." at line ".$e->getLine()
      .PHP_EOL.
      $e->getTraceAsString()
    );
    exit();
} catch (\Error $error) {
    $log->error(
      "In file ".$error->getFile()
      ." ".$error->getMessage()
      ." at line ".$error->getLine()
      .PHP_EOL.
      $error->getTraceAsString()
    );
    exit();
}