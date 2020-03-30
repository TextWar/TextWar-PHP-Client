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
      while(($r=$sock->read())!==null) {
        $log->info("Received: ".$r);
        $pack = isset($pack) ? $pack->append($r) : new Package($r);
        if(($p=$pack->parse()) == Package::ERR_NO_ERROR) {
          $log->notice("Parse Completed");
          unset($pack);
        }else{
          $log->warning("Parse Failed :".$p);
        }
      }
    });
  }
}