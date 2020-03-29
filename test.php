<?php
use textwar\Board;
use textwar\protocol\Package;
use textwar\protocol\Protocol;
echo $code=Protocol::encode(
  [
  "hello"=>"world",
  "im"=>"xMing"
  ]
);
$pack = new Package($code);
$ok = $pack->parse();
if($ok == Package::ERR_NO_ERROR)
{
  var_dump($pack->getData());
  var_dump($pack->getTimestamp());
}else{
  var_dump($ok);
}













$b = new Board(30,25);
echo PHP_EOL;
sleep(2);
/*
$b->active();
while(true)
{
  for($x=0;$x<25;$x++) {
    for($y=0;$y<30;$y++) {
      $b->put($x,$y,"*");
    }
  }
  usleep(5e4);
  for($x=0;$x<25;$x++) {
    for($y=0;$y<30;$y++) {
      $b->put($x,$y," ");
    }
  }
  usleep(5e4);
  $b->refresh();
}*/