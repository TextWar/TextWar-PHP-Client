<?php
use yxmingy\socket\ClientSocket;
use textwar\MapUpdater;
$c = new ClientSocket();
$c->connect("www.xming.fun",2333);
//echo $c->getPeerAddr().PHP_EOL;
use textwar\protocol\Package;
use textwar\protocol\Protocol;
$code=Protocol::encode(
  [
  "hello"=>"world",
  "im"=>"xMing"
  ]
);
$c->write($code);
$updater = new MapUpdater($c->getSocketResource());
$updater->start();
sleep(1);
$c->write($code);
while(($get=trim(fgets(STDIN)))!="exit") {
  $c->write($get);
}
$c->safeClose();
$updater->join();