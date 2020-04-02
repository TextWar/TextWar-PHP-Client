<?php
namespace yxmingy\board\element;
use yxmingy\board\BaseBoard;
class Border extends Element
{
  public function __construct(int $x1,int $y1,int $x2,int $y2,BaseBoard $board)
  {
    parent::__construct($board);
    array_push($this->origin,$x1,$y1);
    $this->height = abs($y1-$y2);
    $this->width = abs($x1-$x2);
    $this->print();
  }
  public function print()
  {
    $this->clear($this->board->getBorderChar());
  }
  public function clear(string $fill = " ")
  {
    ob_start();
    for($x=0;$x<$this->width;$x++) {
      $this->set($x,0,$fill);
    }
    for($y=0;$y<$this->height;$y++) {
      $this->set(0,$y,$fill);
      $this->set($this->width,$y,$fill);
    }
    for($x=0;$x<$this->width;$x++) {
      $this->set($x,$this->height-1,$fill);
    }
    ob_end_flush();
  }
}