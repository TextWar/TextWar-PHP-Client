<?php
function autoload(string $class)
{
  $class = str_replace('\\', '/', $class);
  $file_name = dirname(__FILE__).'/'.$class.'.php';
  require_once $file_name;
}
spl_autoload_register("autoload");
error_reporting(E_ALL);
ini_set('display_errors', false);
$log = new \yxmingy\Logger("[TextWar]");
set_error_handler(function ($error_no, $error_str, $error_file, $error_line) use($log){
    $log->error("In file ".$error_file." ".$error_str."at line ".$error_line);
}, E_ALL | E_STRICT);
try {
    require_once "main.php";
} catch (\Exception $exception) {
    var_export($exception);
} catch (\Error $error) {
    // 就是这里了，try catch 捕捉了 Error
    $log->error(
      "In file ".$error->getFile()
      ." ".$error->getMessage()
      ." at line ".$error->getLine()
      .PHP_EOL.
      $error->getTraceAsString()
    );
}