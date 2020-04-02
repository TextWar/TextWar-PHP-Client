<?php
namespace yxmingy\board\element;
use yxmingy\board\BaseBoard;
class Rectangle extends Element
{
  private $char = "*";
  public function __construct(int $x1,int $y1,int $x2,int $y2,string $char,BaseBoard $board)
  {
    parent::__construct($board);
    array_push($this->origin,$x1,$y1);
    $this->height = abs($y1-$y2);
    $this->width = abs($x1-$x2);
    $this->char = $char;
    $this->print();
  }
  public function print()
  {
    for($y=0;$y<$this->height;$y++) {
      for($x=0;$x<$this->width;$x++) {
        $this->set($x,$y,$this->board->getBorderChar());
      }
    }
  }
  public function setChar(string $char)
  {
    $this->char = $char;
  }
}