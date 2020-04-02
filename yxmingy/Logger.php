<?php
namespace yxmingy;
class Logger
{
  const BLACK = 0;
  const RED = 1;
  const GREEN = 2;
  const YELLOW = 3;
  const BLUE = 4;
  const PURPLE = 5;
  const DARK_GREEN = 6;
  const WHITE = 7;
  private $flag = "[xMing]";
  public function __construct(string $flag)
  {
    $this->flag = $flag;
  }
  public function print(string $msg,int $font_c = null,int $bg_c = null)
  {
    $font = is_null($font_c) ? null : "\033[3".$font_c."m";
    $bg = is_null($bg_c) ? null : "\033[4".$bg_c."m";
    echo $font.$bg.$this->flag.$msg."\033[0m".PHP_EOL;
  }
  public function info(string $msg)
  {
    $this->print("-INFO: ".$msg,self::GREEN);
  }
  public function notice(string $msg)
  {
    $this->print("-NOTE: ".$msg,self::BLUE);
  }
  public function warning(string $msg)
  {
    $this->print("-WARN: ".$msg,self::YELLOW);
  }
  public function error(string $msg)
  {
    $this->print("-ERROR: ".$msg,self::WHITE,self::RED);
  }
}