<?php
namespace textwar;
error_reporting(E_ALL);
use yxmingy\socket\ClientSocket;
use yxmingy\Logger;
require_once("protocol/Package.php");
use textwar\protocol\Package;
class MapUpdater extends \Thread
{
  private $sock;
  public function __construct($sock)
  {
    $this->sock = $sock;
  }
  public function run()
  {
    $this->synchronized(function(){
      $sock = new ClientSocket(AF_INET,SOCK_STREAM,$this->sock);
      $log = new Logger("[TextWar]");
      $retry = 3;
      while(($r=$sock->read())!==null) {
        $log->info("Received: \n".$r);
        $pack = isset($pack) ? $pack->append($r) : new Package($r);
        if(($p=$pack->parse()) == Package::ERR_NO_ERROR) {
          $log->notice("Parse Completed");
          $log->notice("Time-Stamp: ".$pack->getTimestamp());
          ob_start();
          print_r($pack->getData());
          $data = ob_get_contents();
          ob_end_clean();
          $log->notice("Data:\n".$data);
          unset($pack);
          $retry = 3;
        }else{
          switch($p) {
            case Package::ERR_INVALID_HEAD:
            $err = "Invalid Head";
            break;
            case Package::ERR_INVALID_CRLF:
            $err = "Invalid CRLF";
            break;
            case Package::ERR_INVALID_DATA:
            $err = "Invalid Data";
            break;
            case Package::ERR_DATA_LENGTH:
            $err = "Invalid Data Length";
          }
          $log->warning("Parse Failed: ".$err.", There is $retry times to retry.");
          if($retry--<=0) {
            unset($pack);
            $retry = 3;
            $log->warning("Retry times out. Data has been abandoned.");
          }
        }
      }
    });
  }
}