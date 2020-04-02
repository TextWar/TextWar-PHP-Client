<?php
require_once "autoload.php";
require_once "yxmingy/crypt.php";
$b = new \yxmingy\board\CustomBoard(25,25);
$f = $b->addRectangle(5,5,15,15);
$t = $b->addLabel(5,19,10,21);
$t->setContent("I am a test string");
$d = $b->addBorder(4,18,11,22);
echo PHP_EOL;
sleep(2);
//$l->print();
$l = $b->addLine(17);
$b->active();

while(true)
{
  //打开缓冲区
  ob_start();
  //长方形显形
  $f->print();
  $l->print();
  $d->print();
  //刷新缓冲区
  ob_end_flush();
  usleep(5e4);
  
  ob_start();
  //长方形隐藏
  $f->clear();
  $l->clear();
  $d->clear();
  ob_end_flush();
  usleep(5e4);
  
  
  $b->refreshAll();
}